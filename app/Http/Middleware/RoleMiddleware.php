<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Super Admin memiliki hak akses penuh ke seluruh fitur sistem
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Jika rute mencantumkan role yang persis cocok
        if (!empty($roles) && in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Pengecekan dinamis berdasarkan tabel permissions role
        if ($this->userHasPermissionForRoute($user, $request)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak: Anda tidak memiliki izin hak akses untuk tindakan ini.',
            ], 403);
        }

        // Pengalihan cerdas sesuai hak akses yang dimiliki pengguna
        if ($user->hasPermission('dashboard_view')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses dibatasi: Anda tidak memiliki wewenang untuk membuka halaman tersebut.');
        }

        if ($user->hasPermission('articles_view')) {
            return redirect()->route('admin.articles.index')
                ->with('error', 'Akses dibatasi: Anda tidak memiliki izin untuk fitur tersebut.');
        }

        if ($user->hasPermission('registrations_view')) {
            return redirect()->route('admin.registrations.index')
                ->with('error', 'Akses dibatasi: Anda tidak memiliki izin untuk fitur tersebut.');
        }

        return redirect()->route('admin.profile')
            ->with('error', 'Akses dibatasi: Anda tidak memiliki izin untuk membuka halaman tersebut.');
    }

    /**
     * Memeriksa apakah pengguna memiliki hak akses (permission) yang sesuai dengan rute saat ini.
     */
    protected function userHasPermissionForRoute($user, Request $request): bool
    {
        $routeName = $request->route()?->getName() ?? '';

        // Dashboard
        if ($routeName === 'admin.dashboard') {
            return $user->hasPermission('dashboard_view');
        }

        // Berita & Artikel
        if (str_starts_with($routeName, 'admin.articles.')) {
            if (str_ends_with($routeName, '.create') || str_ends_with($routeName, '.store')) {
                return $user->hasPermission('articles_create');
            }
            if (str_ends_with($routeName, '.edit') || str_ends_with($routeName, '.update') || str_contains($routeName, 'toggle-')) {
                return $user->hasPermission('articles_edit');
            }
            if (str_ends_with($routeName, '.destroy')) {
                return $user->hasPermission('articles_delete');
            }
            return $user->hasPermission('articles_view');
        }

        // Kategori Berita
        if (str_starts_with($routeName, 'admin.categories.')) {
            return $user->hasPermission('categories_manage');
        }

        // Galeri Kegiatan
        if (str_starts_with($routeName, 'admin.galleries.')) {
            return $user->hasPermission('articles_view') || $user->hasPermission('articles_create');
        }

        // Pendaftaran Santri Baru (PSB)
        if (str_starts_with($routeName, 'admin.registrations.')) {
            if (str_ends_with($routeName, '.verify')) {
                return $user->hasPermission('registrations_verify');
            }
            if (str_ends_with($routeName, '.approve')) {
                return $user->hasPermission('registrations_approve');
            }
            if (str_ends_with($routeName, '.destroy')) {
                return $user->hasPermission('registrations_delete');
            }
            return $user->hasPermission('registrations_view');
        }

        // Informasi & Gelombang PSB
        if (str_starts_with($routeName, 'admin.psb.')) {
            return $user->hasPermission('registrations_approve') || $user->hasPermission('registrations_verify') || $user->hasPermission('registrations_view');
        }

        // Data Santri Aktif
        if (str_starts_with($routeName, 'admin.students.')) {
            return $user->hasPermission('students_manage');
        }

        // Keuangan & LAZISWAF
        if (str_starts_with($routeName, 'admin.donations.')) {
            return $user->hasPermission('donations_manage');
        }

        // Kelola Pengguna & Role
        if (str_starts_with($routeName, 'admin.users.') || str_starts_with($routeName, 'admin.roles.')) {
            return $user->hasPermission('users_manage');
        }

        // Pengaturan Website
        if (str_starts_with($routeName, 'admin.settings.')) {
            return $user->hasPermission('settings_manage');
        }

        // Histori Aktivitas
        if (str_starts_with($routeName, 'admin.activity-logs.')) {
            return $user->hasPermission('logs_view');
        }

        return false;
    }
}
