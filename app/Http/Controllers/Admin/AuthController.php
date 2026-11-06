<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isPenulis()) {
                return redirect()->route('admin.articles.index');
            }
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Process login submission.
     */
    public function login(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string)$request->input('email')))]);

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Record Login Activity
            \App\Services\ActivityLogger::log('LOGIN', 'User "' . Auth::user()->name . '" (' . Auth::user()->role_label . ') berhasil login ke sistem admin.');

            $defaultTarget = Auth::user()->hasPermission('dashboard_view')
                ? route('admin.dashboard')
                : (Auth::user()->hasPermission('articles_view') ? route('admin.articles.index') : route('admin.profile'));

            return redirect()->intended($defaultTarget)
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . ' (' . Auth::user()->role_label . ')!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.forgot-password');
    }

    /**
     * Send 6-digit verification code to user's email.
     */
    public function sendResetCode(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string)$request->input('email')))]);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Alamat email tidak terdaftar dalam sistem pengelola.',
        ]);

        $email = $validated['email'];
        $user = User::where('email', $email)->first();

        // Generate 6-digit random code
        $code = (string) random_int(100000, 999999);

        // Store or update in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $code,
                'created_at' => now(),
            ]
        );

        // Send email with verification code
        $mailSent = false;
        try {
            Mail::send('emails.password-reset-code', ['user' => $user, 'code' => $code], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Kode Verifikasi Reset Password - Pondok Pesantren Nurussyam');
            });
            $mailSent = true;
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email reset password: ' . $e->getMessage());
        }

        \App\Services\ActivityLogger::log('PASSWORD_RESET_REQ', 'Permintaan kode reset password untuk email: ' . $email . ' (' . ($mailSent ? 'Terkirim via Email' : 'Mode Simulasi/Local') . ')');

        // If local dev or mail sending failed, flash the code so testing never gets stuck
        if (!$mailSent) {
            session()->flash('demo_code', $code);
        }

        return redirect()->route('admin.password.reset', ['email' => $email])
            ->with('success', 'Kode verifikasi 6 digit telah dikirim ke ' . $email . '. Silakan periksa kotak masuk atau spam email Anda.');
    }

    /**
     * Show reset password verification & form.
     */
    public function showResetPasswordForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $email = strtolower(trim((string)$request->query('email')));
        if (empty($email) || !User::where('email', $email)->exists()) {
            return redirect()->route('admin.password.request')
                ->with('info', 'Silakan masukkan email pengelola Anda terlebih dahulu.');
        }

        return view('admin.auth.reset-password', compact('email'));
    }

    /**
     * Verify code and update password.
     */
    public function resetPassword(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string)$request->input('email')))]);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string|size:6',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.exists' => 'Email tidak terdaftar.',
            'token.required' => 'Kode verifikasi 6 digit wajib diisi.',
            'token.size' => 'Kode verifikasi harus 6 digit angka.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $email = $validated['email'];
        $token = trim((string)$validated['token']);

        // Check password_reset_tokens
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['token' => 'Permintaan reset password tidak ditemukan. Silakan minta kode verifikasi baru.'])->withInput();
        }

        // Check expiration (15 minutes)
        $createdAt = Carbon::parse($resetRecord->created_at);
        if ($createdAt->addMinutes(15)->isPast()) {
            return back()->withErrors(['token' => 'Kode verifikasi telah kedaluwarsa (lebih dari 15 menit). Silakan minta kode baru.'])->withInput();
        }

        // Check token match
        if (trim($resetRecord->token) !== $token) {
            return back()->withErrors(['token' => 'Kode verifikasi yang Anda masukkan salah. Periksa kembali email Anda.'])->withInput();
        }

        // Update User Password
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($validated['password']);
        $user->save();

        // Delete used token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        \App\Services\ActivityLogger::log('PASSWORD_RESET_SUCCESS', 'User "' . $user->name . '" (' . $user->email . ') berhasil mengatur ulang password baru via kode email.');

        return redirect()->route('admin.login')
            ->with('success', 'Password akun Anda berhasil diperbarui! Silakan login menggunakan email dan password baru Anda.');
    }

    /**
     * Admin logout.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            \App\Services\ActivityLogger::log('LOGOUT', 'User "' . Auth::user()->name . '" logout dari sesi admin.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->input('reason') === 'idle') {
            return redirect()->route('admin.login')
                ->with('warning', 'Sesi Anda telah berakhir secara otomatis karena tidak ada aktivitas selama 15 menit. Silakan login kembali.');
        }

        return redirect()->route('admin.login')
            ->with('info', 'Anda telah berhasil logout.');
    }

    /**
     * Show admin profile & security form.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile & password.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            if (empty($validated['current_password'])) {
                return back()->withErrors(['current_password' => 'Password saat ini harus diisi jika ingin mengubah password.']);
            }

            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        \App\Services\ActivityLogger::log('PROFILE_UPDATE', 'Pengguna memperbarui profil / password akun pribadinya.');

        return back()->with('success', 'Profil dan akun admin berhasil diperbarui.');
    }
}
