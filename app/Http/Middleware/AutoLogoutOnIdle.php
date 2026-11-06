<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ActivityLogger;

class AutoLogoutOnIdle
{
    /**
     * Timeout in seconds of inactivity (15 minutes = 900 seconds).
     */
    protected int $idleTimeout = 900;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = $request->session()->get('admin_last_activity_time');
            $now = time();

            if ($lastActivity && ($now - $lastActivity > $this->idleTimeout)) {
                $userName = Auth::user()->name ?? 'Pengguna';
                
                // Record activity log
                try {
                    ActivityLogger::log('LOGOUT_IDLE', 'User "' . $userName . '" otomatis logout oleh sistem karena tidak ada aktivitas selama 15 menit.');
                } catch (\Throwable $e) {
                    // ignore logger failures
                }

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'status' => 'session_expired',
                        'message' => 'Sesi Anda telah berakhir karena tidak ada aktivitas selama 15 menit. Silakan login kembali.',
                    ], 401);
                }

                return redirect()->route('admin.login')
                    ->with('warning', 'Sesi Anda telah berakhir secara otomatis karena tidak ada aktivitas selama 15 menit. Silakan login kembali.');
            }

            // Update timestamp
            $request->session()->put('admin_last_activity_time', $now);
        }

        return $next($request);
    }
}
