<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Record an activity into the database.
     *
     * @param string $action Action key (e.g., 'LOGIN', 'ARTIKEL_CREATE', 'PSB_VERIFIKASI')
     * @param string $description Human-friendly description of the action
     * @param mixed $user Optional user instance; defaults to Auth::user()
     * @return ActivityLog|null
     */
    public static function log(string $action, string $description, $user = null): ?ActivityLog
    {
        try {
            $currentUser = $user ?: Auth::user();

            $userId = $currentUser?->id;
            $userName = $currentUser?->name ?: 'Tamu / Publik';
            $role = $currentUser?->role ?: 'guest';

            return ActivityLog::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'role' => $role,
                'action' => strtoupper($action),
                'description' => $description,
                'ip_address' => Request::ip() ?: '127.0.0.1',
                'user_agent' => substr(Request::userAgent() ?? 'Unknown Agent', 0, 500),
            ]);
        } catch (\Throwable $e) {
            // Silently fail to avoid breaking main workflow if logging encounters issues
            report($e);
            return null;
        }
    }
}
