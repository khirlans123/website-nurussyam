<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    /**
     * Display donations and Laziswaf records.
     */
    public function index(Request $request)
    {
        $query = Donation::query()->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_donatur', 'like', "%{$search}%")
                  ->orWhere('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('no_wa', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $donations = $query->paginate(12)->withQueryString();

        $stats = [
            'total_nominal' => Donation::where('status', 'Terverifikasi')->sum('nominal'),
            'total_count' => Donation::count(),
            'pending_count' => Donation::where('status', 'Menunggu Konfirmasi')->count(),
        ];

        return view('admin.donations.index', compact('donations', 'stats'));
    }

    /**
     * Store a new donation record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'no_wa' => 'required|string|max:30',
            'program' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1000',
            'bank_tujuan' => 'required|string|max:50',
            'doa_harapan' => 'nullable|string|max:500',
            'status' => 'required|string|in:Menunggu Konfirmasi,Terverifikasi',
        ]);

        $kode = 'DON-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

        $donation = Donation::create([
            'kode_transaksi' => $kode,
            'nama_donatur' => $validated['nama_donatur'],
            'no_wa' => $validated['no_wa'],
            'program' => $validated['program'],
            'nominal' => $validated['nominal'],
            'bank_tujuan' => $validated['bank_tujuan'],
            'status' => $validated['status'],
            'doa_harapan' => $validated['doa_harapan'] ?? null,
        ]);

        \App\Services\ActivityLogger::log('DONASI_TAMBAH', "Mencatat donasi manual: {$donation->kode_transaksi} ({$donation->nama_donatur} - Rp " . number_format($donation->nominal, 0, ',', '.') . ")");

        return back()->with('success', 'Data donasi berhasil dicatat.');
    }

    /**
     * Mark donation as verified.
     */
    public function verify(Donation $donation)
    {
        $donation->update(['status' => 'Terverifikasi']);
        \App\Services\ActivityLogger::log('DONASI_VERIFIKASI', "Memverifikasi transaksi donasi {$donation->kode_transaksi} ({$donation->nama_donatur})");
        return back()->with('success', 'Donasi ' . $donation->kode_transaksi . ' berhasil diverifikasi.');
    }

    /**
     * Delete donation record.
     */
    public function destroy(Donation $donation)
    {
        $kode = $donation->kode_transaksi;
        $donation->delete();
        \App\Services\ActivityLogger::log('DONASI_HAPUS', "Menghapus data donasi: {$kode}");
        return back()->with('success', 'Data donasi berhasil dihapus.');
    }
}
