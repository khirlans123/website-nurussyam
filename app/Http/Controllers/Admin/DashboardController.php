<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Registration;
use App\Models\Donation;
use App\Models\Category;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with statistics and recent data.
     */
    public function index()
    {
        // Pengecekan izin dashboard dinamis
        if (!auth()->user()?->hasPermission('dashboard_view')) {
            if (auth()->user()?->hasPermission('articles_view')) {
                return redirect()->route('admin.articles.index');
            }
            if (auth()->user()?->hasPermission('registrations_view')) {
                return redirect()->route('admin.registrations.index');
            }
            return redirect()->route('admin.profile');
        }

        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('is_published', true)->count(),
            'draft_articles' => Article::where('is_published', false)->count(),
            'featured_articles' => Article::where('is_featured', true)->count(),
            'total_views' => (int) Article::sum('views_count'),

            'total_registrations' => Registration::count(),
            'pending_registrations' => Registration::where('status', 'Pending')->count(),
            'verified_registrations' => Registration::where('status', 'Diverifikasi')->count(),
            'accepted_registrations' => Registration::where('status', 'Diterima')->count(),

            'total_donations' => Donation::count(),
            'total_donations_amount' => (float) Donation::sum('nominal'),
            'verified_donations_amount' => (float) Donation::where('status', 'Terverifikasi')->sum('nominal'),

            'total_categories' => Category::count(),
        ];

        $recentStudents = Registration::where('status', 'Diterima')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        $recentArticles = Article::with('categoryRel')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $recentRegistrations = Registration::where('status', 'Pending')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $recentDonations = Donation::orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // 6-Month PSB Registration & Accepted Students Trend
        $chartMonths = [];
        $chartRegistrations = [];
        $chartAccepted = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $chartMonths[] = $date->locale('id')->isoFormat('MMM Y');

            $chartRegistrations[] = Registration::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $chartAccepted[] = Registration::where('status', 'Diterima')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Education Unit Distribution
        $jenjangLabels = ['MTs Nurussyam', 'MA Nurussyam', 'Tahfidz Al-Qur\'an', 'Madrasah Diniyah'];
        $jenjangCounts = [
            Registration::where('pilihan_jenjang', 'like', '%MTS%')->count(),
            Registration::where('pilihan_jenjang', 'like', '%MA%')->count(),
            Registration::where('pilihan_jenjang', 'like', '%Tahfidz%')->count(),
            Registration::where('pilihan_jenjang', 'like', '%Diniyah%')->count(),
        ];

        // Gender Distribution
        $genderLabels = ['Santri Putra', 'Santri Putri'];
        $genderCounts = [
            Registration::where('jenis_kelamin', 'Laki-laki')->count(),
            Registration::where('jenis_kelamin', 'Perempuan')->count(),
        ];

        // Status Distribution
        $statusLabels = ['Diterima', 'Diverifikasi', 'Pending', 'Ditolak'];
        $statusCounts = [
            $stats['accepted_registrations'],
            $stats['verified_registrations'],
            $stats['pending_registrations'],
            Registration::where('status', 'Ditolak')->count(),
        ];

        $chartData = [
            'months' => $chartMonths,
            'registrations' => $chartRegistrations,
            'accepted' => $chartAccepted,
            'jenjang' => [
                'labels' => $jenjangLabels,
                'data' => $jenjangCounts,
            ],
            'gender' => [
                'labels' => $genderLabels,
                'data' => $genderCounts,
            ],
            'status' => [
                'labels' => $statusLabels,
                'data' => $statusCounts,
            ],
        ];

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentRegistrations', 'recentStudents', 'recentDonations', 'chartData'));
    }
}
