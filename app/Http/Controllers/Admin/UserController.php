<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $roleFilter = $request->input('role');
        $search = $request->input('q');

        $query = User::query()->orderBy('name', 'asc');

        if ($roleFilter && in_array($roleFilter, ['admin', 'staff', 'penulis'])) {
            $query->where('role', $roleFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'penulis' => User::where('role', 'penulis')->count(),
        ];

        $availableRoles = \App\Models\Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'stats', 'roleFilter', 'search', 'availableRoles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validRoles = \App\Models\Role::pluck('slug')->toArray();
        if (empty($validRoles)) {
            $validRoles = ['admin', 'staff', 'penulis'];
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in($validRoles)],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'role.in' => 'Role akses yang dipilih tidak valid.',
        ]);

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        \App\Services\ActivityLogger::log(
            'USER_CREATE',
            'Menambahkan akun pengguna baru: "' . $newUser->name . '" (Email: ' . $newUser->email . ', Role: ' . $newUser->role_label . ')'
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun ' . $validated['name'] . ' (' . $newUser->role_label . ') berhasil dibuat!');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validRoles = \App\Models\Role::pluck('slug')->toArray();
        if (empty($validRoles)) {
            $validRoles = ['admin', 'staff', 'penulis'];
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in($validRoles)],
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email sudah digunakan pengguna lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
        ]);

        // Prevent admin from removing their own admin role
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'Anda tidak dapat mengubah role akun admin Anda sendiri.');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        \App\Services\ActivityLogger::log(
            'USER_UPDATE',
            'Memperbarui data akun pengguna: "' . $user->name . '" (Role: ' . $user->role_label . ')'
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Data akun ' . $user->name . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $name = $user->name;
        $user->delete();

        \App\Services\ActivityLogger::log(
            'USER_DELETE',
            'Menghapus akun pengguna: "' . $name . '"'
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna "' . $name . '" telah berhasil dihapus.');
    }
}
