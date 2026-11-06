<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Role;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of system activity logs.
     */
    public function index(Request $request)
    {
        $roleFilter = $request->input('role');
        $actionFilter = $request->input('action');
        $search = $request->input('q');

        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        if ($roleFilter) {
            $query->where('role', $roleFilter);
        }

        if ($actionFilter) {
            if ($actionFilter === 'AUTH') {
                $query->whereIn('action', ['LOGIN', 'LOGOUT']);
            } elseif ($actionFilter === 'ARTIKEL') {
                $query->where('action', 'like', 'ARTIKEL%');
            } elseif ($actionFilter === 'PSB') {
                $query->where('action', 'like', 'PSB%');
            } elseif ($actionFilter === 'SANTRI') {
                $query->where('action', 'like', 'SANTRI%');
            } elseif ($actionFilter === 'SYSTEM') {
                $query->whereIn('action', ['SETTINGS_UPDATE', 'USER_CREATE', 'USER_UPDATE', 'USER_DELETE', 'ROLE_CREATE', 'ROLE_UPDATE', 'ROLE_DELETE']);
            } else {
                $query->where('action', $actionFilter);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'logins_today' => ActivityLog::where('action', 'LOGIN')->whereDate('created_at', today())->count(),
            'articles_today' => ActivityLog::where('action', 'like', 'ARTIKEL%')->whereDate('created_at', today())->count(),
            'psb_today' => ActivityLog::where('action', 'like', 'PSB%')->whereDate('created_at', today())->count(),
        ];

        $roles = Role::orderBy('name')->get();

        return view('admin.activity_logs.index', compact('logs', 'stats', 'roleFilter', 'actionFilter', 'search', 'roles'));
    }

    /**
     * Clear old logs (admin maintenance).
     */
    public function clearOld(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', "Arsip log yang lebih lama dari {$days} hari berhasil dibersihkan ({$deleted} catatan dihapus).");
    }
}
