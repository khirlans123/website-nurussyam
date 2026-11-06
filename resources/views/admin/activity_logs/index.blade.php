@extends('admin.layout')

@section('title', 'Histori Aktivitas & Role Pengguna')
@section('page_title', 'Histori Aktivitas')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Histori Aktivitas & Role Pengguna</span>
            </h1>
            <p class="page-head-subtitle">Audit trail rekam jejak sistem: pantau jam login, role pengguna, dan setiap tindakan yang dilakukan pengelola.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Kelola Role Akses</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-users"></i>
                <span>Data Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="adm-stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-slate"><i class="fa-solid fa-database"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($stats['total']) }}</span>
                <span class="stat-label">Total Jejak Aktivitas</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-emerald"><i class="fa-solid fa-calendar-day"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($stats['today']) }}</span>
                <span class="stat-label">Aktivitas Hari Ini</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-blue"><i class="fa-solid fa-right-to-bracket"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($stats['logins_today']) }}</span>
                <span class="stat-label">Sesi Login Hari Ini</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-purple"><i class="fa-solid fa-newspaper"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($stats['articles_today']) }}</span>
                <span class="stat-label">Aktivitas Berita</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-amber"><i class="fa-solid fa-user-graduate"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($stats['psb_today']) }}</span>
                <span class="stat-label">Aktivitas PSB Santri</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="adm-card" style="margin-bottom: 1.25rem;">
        <div class="adm-card-body" style="padding: 1rem 1.25rem;">
            <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="adm-toolbar-form">
                <div style="flex: 2; min-width: 180px;">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama pengguna, detail tindakan, atau IP address...">
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>

                <div style="flex: 1; min-width: 140px;">
                    <select name="role" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Role --</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff PSB & Berita</option>
                        <option value="penulis" {{ request('role') === 'penulis' ? 'selected' : '' }}>Penulis Berita</option>
                        @foreach($roles as $r)
                            @if(!in_array($r->slug, ['admin', 'staff', 'penulis']))
                                <option value="{{ $r->slug }}" {{ request('role') === $r->slug ? 'selected' : '' }}>{{ $r->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div style="flex: 1; min-width: 150px;">
                    <select name="action" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Tipe Tindakan --</option>
                        <option value="AUTH" {{ request('action') === 'AUTH' ? 'selected' : '' }}>🔑 Login & Logout</option>
                        <option value="ARTIKEL" {{ request('action') === 'ARTIKEL' ? 'selected' : '' }}>📰 Berita & Artikel</option>
                        <option value="PSB" {{ request('action') === 'PSB' ? 'selected' : '' }}>🎓 Pendaftaran PSB</option>
                        <option value="SANTRI" {{ request('action') === 'SANTRI' ? 'selected' : '' }}>👤 Data Santri Aktif</option>
                        <option value="SYSTEM" {{ request('action') === 'SYSTEM' ? 'selected' : '' }}>⚙️ Pengaturan & Pengguna</option>
                    </select>
                </div>

                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1rem;">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter</span>
                    </button>

                    @if(request()->hasAny(['q', 'role', 'action']))
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary" style="padding: 0.6rem 1rem;" title="Reset Filter">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table Log -->
    <div class="adm-card">
        <div class="adm-card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
            <h2 class="adm-card-title">
                <i class="fa-solid fa-list-check"></i>
                <span>Catatan Histori Masuk & Aktivitas User</span>
            </h2>

            <form action="{{ route('admin.activity-logs.clear-old') }}" method="POST" onsubmit="return confirm('Bersihkan arsip log aktivitas yang lebih lama dari 30 hari?')">
                @csrf
                <input type="hidden" name="days" value="30">
                <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 0.76rem; color: #dc2626; border-color: #fca5a5;">
                    <i class="fa-solid fa-broom"></i>
                    <span>Bersihkan Log > 30 Hari</span>
                </button>
            </form>
        </div>

        <div class="adm-card-body" style="padding: 0;">
            <!-- Desktop Table View -->
            <div class="desktop-only-table table-responsive">
                <table class="adm-table" style="min-width: 950px; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 175px;">Waktu & Jam</th>
                            <th style="width: 220px;">Pengguna & Role</th>
                            <th style="width: 150px;">Tipe Aksi</th>
                            <th>Aktivitas Yang Dilakukan</th>
                            <th style="width: 160px; text-align: right;">IP & Perangkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            @php
                                $badge = $log->action_badge;
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;">
                                    <div style="font-weight: 700; color: var(--adm-text-main); font-size: 0.85rem;">
                                        <i class="fa-regular fa-clock" style="color: var(--adm-primary); margin-right: 0.25rem;"></i>
                                        {{ $log->created_at->format('H:i:s') }} WIB
                                    </div>
                                    <div style="font-size: 0.73rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                        {{ $log->created_at->translatedFormat('d M Y') }} &bull; {{ $log->created_at->diffForHumans() }}
                                    </div>
                                </td>

                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #334155; font-size: 0.8rem; flex-shrink: 0;">
                                            {{ strtoupper(substr($log->user_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--adm-text-main); font-size: 0.88rem;">
                                                {{ $log->user_name }}
                                            </div>
                                            <div style="margin-top: 0.15rem;">
                                                @if($log->role === 'admin')
                                                    <span class="badge badge-emerald" style="font-size: 0.65rem; padding: 0.1rem 0.4rem;">
                                                        <i class="fa-solid fa-shield-halved"></i> Super Admin
                                                    </span>
                                                @elseif($log->role === 'staff')
                                                    <span class="badge badge-blue" style="font-size: 0.65rem; padding: 0.1rem 0.4rem;">
                                                        <i class="fa-solid fa-user-check"></i> Staff PSB
                                                    </span>
                                                @elseif($log->role === 'penulis')
                                                    <span class="badge badge-amber" style="font-size: 0.65rem; padding: 0.1rem 0.4rem;">
                                                        <i class="fa-solid fa-feather-pointed"></i> Penulis
                                                    </span>
                                                @else
                                                    <span class="badge badge-slate" style="font-size: 0.65rem; padding: 0.1rem 0.4rem;">
                                                        {{ ucfirst(str_replace('_', ' ', $log->role)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td style="white-space: nowrap;">
                                    <span class="badge {{ $badge['class'] }}" style="font-size: 0.74rem; padding: 0.25rem 0.55rem;">
                                        <i class="{{ $badge['icon'] }}" style="margin-right: 0.25rem;"></i>
                                        {{ $badge['text'] }}
                                    </span>
                                </td>

                                <td>
                                    <div style="font-size: 0.85rem; color: var(--adm-text-main); line-height: 1.45; font-weight: 500;">
                                        {{ $log->description }}
                                    </div>
                                </td>

                                <td style="text-align: right; white-space: nowrap;">
                                    <div style="font-family: monospace; font-size: 0.78rem; color: #475569; font-weight: 600;">
                                        {{ $log->ip_address ?: '127.0.0.1' }}
                                    </div>
                                    <div style="font-size: 0.7rem; color: var(--adm-text-muted); margin-top: 0.15rem; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $log->user_agent }}">
                                        @if(str_contains(strtolower($log->user_agent), 'mobile') || str_contains(strtolower($log->user_agent), 'android') || str_contains(strtolower($log->user_agent), 'iphone'))
                                            <i class="fa-solid fa-mobile-screen"></i> Smartphone
                                        @else
                                            <i class="fa-solid fa-desktop"></i> Komputer / Laptop
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem 1rem;">
                                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 0.75rem;"></i>
                                    <div style="font-weight: 600; color: var(--adm-text-main);">Belum ada rekam jejak aktivitas</div>
                                    <p style="font-size: 0.82rem; color: var(--adm-text-muted); margin-top: 0.25rem;">
                                        Setiap tindakan user, jam login, dan aktivitas di panel admin akan tercatat otomatis di sini.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Touch-Friendly Card List (Phone Only) -->
            <div class="mobile-only-cards">
                @forelse($logs as $log)
                    @php
                        $badge = $log->action_badge;
                    @endphp
                    <div class="mobile-card">
                        <div class="mobile-card-header" style="align-items: flex-start;">
                            <div style="display: flex; align-items: center; gap: 0.6rem; min-width: 0; flex: 1;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #334155; font-size: 0.85rem; flex-shrink: 0; border: 2px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                    {{ strtoupper(substr($log->user_name, 0, 1)) }}
                                </div>
                                <div style="min-width: 0; flex: 1;">
                                    <div class="mobile-card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.92rem;">
                                        {{ $log->user_name }}
                                    </div>
                                    <div style="margin-top: 0.15rem;">
                                        @if($log->role === 'admin')
                                            <span class="badge badge-emerald" style="font-size: 0.63rem; padding: 0.1rem 0.35rem;">
                                                <i class="fa-solid fa-shield-halved"></i> Super Admin
                                            </span>
                                        @elseif($log->role === 'staff')
                                            <span class="badge badge-blue" style="font-size: 0.63rem; padding: 0.1rem 0.35rem;">
                                                <i class="fa-solid fa-user-check"></i> Staff PSB
                                            </span>
                                        @elseif($log->role === 'penulis')
                                            <span class="badge badge-amber" style="font-size: 0.63rem; padding: 0.1rem 0.35rem;">
                                                <i class="fa-solid fa-feather-pointed"></i> Penulis
                                            </span>
                                        @else
                                            <span class="badge badge-slate" style="font-size: 0.63rem; padding: 0.1rem 0.35rem;">
                                                {{ ucfirst(str_replace('_', ' ', $log->role)) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div style="text-align: right; flex-shrink: 0;">
                                <div style="font-weight: 700; color: var(--adm-text-main); font-size: 0.8rem;">
                                    <i class="fa-regular fa-clock" style="color: var(--adm-primary);"></i>
                                    {{ $log->created_at->format('H:i:s') }}
                                </div>
                                <div style="font-size: 0.68rem; color: var(--adm-text-muted); margin-top: 0.1rem;">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div class="mobile-card-body" style="padding: 0.55rem 0;">
                            <div style="margin-bottom: 0.35rem;">
                                <span class="badge {{ $badge['class'] }}" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">
                                    <i class="{{ $badge['icon'] }}" style="margin-right: 0.25rem;"></i>
                                    {{ $badge['text'] }}
                                </span>
                            </div>
                            <div style="font-size: 0.82rem; color: var(--adm-text-main); line-height: 1.45; font-weight: 500;">
                                {{ $log->description }}
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.72rem; color: var(--adm-text-muted); padding-top: 0.2rem;">
                            <div style="display: flex; align-items: center; gap: 0.35rem;">
                                @if(str_contains(strtolower($log->user_agent), 'mobile') || str_contains(strtolower($log->user_agent), 'android') || str_contains(strtolower($log->user_agent), 'iphone'))
                                    <i class="fa-solid fa-mobile-screen"></i> Smartphone
                                @else
                                    <i class="fa-solid fa-desktop"></i> Komputer
                                @endif
                                <span>&bull;</span>
                                <span style="font-family: monospace;">{{ $log->ip_address ?: '127.0.0.1' }}</span>
                            </div>
                            <div style="font-size: 0.72rem;">
                                {{ $log->created_at->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2.5rem 1rem; color: var(--adm-text-muted);">
                        <i class="fa-solid fa-clock-rotate-left" style="font-size: 2.2rem; color: #cbd5e1; display: block; margin-bottom: 0.5rem;"></i>
                        <div style="font-weight: 600; color: var(--adm-text-main); font-size: 0.88rem;">Belum ada rekam jejak aktivitas</div>
                        <p style="font-size: 0.76rem; margin-top: 0.2rem;">
                            Setiap tindakan user, jam login, dan aktivitas di panel admin akan tercatat otomatis di sini.
                        </p>
                    </div>
                @endforelse
            </div>

            @if($logs->hasPages())
                <div style="padding: 1.25rem;">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
