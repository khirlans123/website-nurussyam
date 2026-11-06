<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

class RegistrationController extends Controller
{
    /**
     * Build base query for PSB registrations with filters.
     */
    protected function buildRegistrationQuery(Request $request)
    {
        $query = Registration::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('no_wa', 'like', "%{$search}%")
                  ->orWhere('asal_sekolah', 'like', "%{$search}%")
                  ->orWhere('nama_wali', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenjang')) {
            $query->where('pilihan_jenjang', 'like', "%{$request->jenjang}%");
        }

        return $query;
    }

    /**
     * Display listing of PSB registrations.
     */
    public function index(Request $request)
    {
        $query = $this->buildRegistrationQuery($request)->orderBy('id', 'desc');
        $registrations = $query->paginate(12)->withQueryString();

        $stats = [
            'total' => Registration::count(),
            'pending' => Registration::where('status', 'Pending')->count(),
            'diverifikasi' => Registration::where('status', 'Diverifikasi')->count(),
            'diterima' => Registration::where('status', 'Diterima')->count(),
            'ditolak' => Registration::where('status', 'Ditolak')->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'stats'));
    }

    /**
     * Export PSB registrations to Excel-compatible CSV.
     */
    public function exportExcel(Request $request)
    {
        $registrations = $this->buildRegistrationQuery($request)->orderBy('id', 'desc')->get();

        $filename = 'Data-Pendaftaran-PSB-PP-Nurussyam-' . date('Ymd-His') . '.csv';

        \App\Services\ActivityLogger::log(
            'PSB_EKSPOR',
            'Mengekspor ' . $registrations->count() . ' data pendaftaran santri baru (PSB) ke format Excel/CSV.'
        );

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'No',
                'No. Pendaftaran',
                'Nama Lengkap Calon Santri',
                'NISN',
                'NIK',
                'Jenis Kelamin',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Jenjang Pilihan',
                'Nama Orang Tua / Wali',
                'No. WhatsApp',
                'Asal Sekolah',
                'Alamat Lengkap',
                'Status Pendaftaran',
                'Tanggal Mendaftar',
                'Catatan Panitia',
            ]);

            $no = 1;
            foreach ($registrations as $r) {
                fputcsv($file, [
                    $no++,
                    $r->no_pendaftaran,
                    $r->nama_lengkap,
                    $r->nisn ? "'" . $r->nisn : '-',
                    $r->nik ? "'" . $r->nik : '-',
                    $r->jenis_kelamin,
                    $r->tempat_lahir ?? '-',
                    $r->tanggal_lahir ? "'" . $r->tanggal_lahir->format('d/m/Y') : '-',
                    str_replace('Salafiyah', "Ma'had Nurussyam", $r->pilihan_jenjang),
                    $r->nama_wali ?? '-',
                    $r->no_wa ? "'" . $r->no_wa : '-',
                    $r->asal_sekolah ?? '-',
                    $r->alamat ?? '-',
                    $r->status,
                    $r->created_at ? "'" . $r->created_at->format('d/m/Y H:i') : '-',
                    $r->catatan ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display printable official summary of PSB registrations (Hard File / PDF ready).
     */
    public function printRekap(Request $request)
    {
        $query = $this->buildRegistrationQuery($request);

        // Hanya santri yang telah berstatus resmi (Diterima) yang dimunculkan pada cetak hard file
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'Diterima');
        }

        $registrations = $query->orderBy('id', 'desc')->get();

        $stats = [
            'total' => $registrations->count(),
            'putra' => $registrations->where('jenis_kelamin', 'Laki-laki')->count(),
            'putri' => $registrations->where('jenis_kelamin', 'Perempuan')->count(),
        ];

        $filterInfo = [
            'q' => $request->q,
            'status' => $request->status ?? 'Diterima',
            'jenjang' => $request->jenjang,
        ];

        \App\Services\ActivityLogger::log(
            'PSB_CETAK_REKAP',
            'Membuka lembar cetak fisik rekap pendaftaran PSB resmi (' . $registrations->count() . ' data).'
        );

        return view('admin.registrations.print-rekap', compact('registrations', 'stats', 'filterInfo'));
    }

    /**
     * Display details of a registration.
     */
    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Verify registration (STAFF ONLY - Verifikasi berkas santri).
     */
    public function verify(Request $request, Registration $registration)
    {
        if (!auth()->user()->isStaff()) {
            return back()->with('error', 'Akses Ditolak: Tugas verifikasi berkas pendaftaran khusus dilakukan oleh Staff Panitia PSB.');
        }

        if ($registration->status === 'Diterima') {
            return back()->with('info', 'Pendaftaran santri ' . $registration->nama_lengkap . ' sudah resmi Diterima.');
        }

        $petugas = auth()->user()->name . ' (Staff PSB)';
        $catatan = $request->input('catatan') ?: 'Berkas pendaftaran telah diverifikasi & dinyatakan lengkap oleh ' . $petugas . ' pada ' . now()->translatedFormat('d F Y, H:i') . ' WIB.';

        $registration->update([
            'status' => 'Diverifikasi',
            'catatan' => $catatan,
        ]);

        \App\Services\ActivityLogger::log(
            'PSB_VERIFIKASI',
            'Staff memverifikasi berkas pendaftaran calon santri: "' . $registration->nama_lengkap . '" (' . $registration->no_pendaftaran . ')'
        );

        return back()->with('success', 'Pendaftaran calon santri ' . $registration->nama_lengkap . ' BERHASIL DIVERIFIKASI oleh Staff! Pendaftaran sekarang telah siap disetujui di panel Admin.');
    }

    /**
     * Approve registration (Setujui pendaftaran menjadi Diterima - ADMIN ONLY).
     * Syarat: Wajib sudah berstatus 'Diverifikasi' terlebih dahulu!
     */
    public function approve(Request $request, Registration $registration)
    {
        if (!auth()->user()->isAdmin()) {
            return back()->with('error', 'Akses Ditolak: Hanya Admin yang berwenang memberikan persetujuan penerimaan santri baru.');
        }

        // WAJIB: Pastikan berkas pendaftaran sudah diverifikasi oleh staff sebelum disetujui
        if ($registration->status !== 'Diverifikasi') {
            return back()->with('error', 'Pendaftaran ' . $registration->nama_lengkap . ' belum diverifikasi oleh staff! Berkas harus diverifikasi terlebih dahulu sebelum Admin dapat menyetujuinya.');
        }

        $catatan = $request->input('catatan') ?: 'Disetujui oleh Administrator Nurussyam pada ' . now()->translatedFormat('d F Y, H:i') . ' WIB.';
        
        $registration->update([
            'status' => 'Diterima',
            'catatan' => $catatan,
        ]);

        \App\Services\ActivityLogger::log(
            'PSB_SETUJUI',
            'Menyetujui pendaftaran & menerima santri: "' . $registration->nama_lengkap . '" (No. Reg: ' . $registration->no_pendaftaran . ', Jenjang: ' . $registration->pilihan_jenjang . ')'
        );

        return back()->with('success', 'Pendaftaran ' . $registration->nama_lengkap . ' (' . $registration->no_pendaftaran . ') BERHASIL DISETUJUI & DITERIMA!');
    }

    /**
     * Reject registration (Tolak pendaftaran - ADMIN ONLY).
     */
    public function reject(Request $request, Registration $registration)
    {
        if (!auth()->user()->isAdmin()) {
            return back()->with('error', 'Akses Ditolak: Hanya Admin yang berwenang menolak pendaftaran.');
        }

        $alasan = $request->input('catatan') ?: 'Pendaftaran belum dapat diterima / dibatalkan.';
        
        $registration->update([
            'status' => 'Ditolak',
            'catatan' => $alasan,
        ]);

        \App\Services\ActivityLogger::log(
            'PSB_HAPUS',
            'Menolak pendaftaran santri: "' . $registration->nama_lengkap . '" (' . $registration->no_pendaftaran . ')'
        );

        return back()->with('warning', 'Pendaftaran ' . $registration->nama_lengkap . ' (' . $registration->no_pendaftaran . ') telah DITOLAK.');
    }

    /**
     * Update status and notes (Staff limited to Pending & Diverifikasi).
     */
    public function updateStatus(Request $request, Registration $registration)
    {
        $allowedStatuses = auth()->user()->isAdmin()
            ? 'Pending,Diverifikasi,Diterima'
            : 'Pending,Diverifikasi';

        $validated = $request->validate([
            'status' => 'required|in:' . $allowedStatuses,
            'catatan' => 'nullable|string|max:500',
        ], [
            'status.in' => 'Status yang dipilih tidak diizinkan untuk peran akun Anda. Persetujuan santri diterima merupakan wewenang Admin.',
        ]);

        if (!auth()->user()->isAdmin() && $validated['status'] === 'Diterima') {
            return back()->with('error', 'Akses Ditolak: Staff hanya dapat memverifikasi berkas. Persetujuan keterima santri hanya dari Admin.');
        }

        // Jika Admin memilih Diterima, pastikan sudah pernah diverifikasi
        if ($validated['status'] === 'Diterima' && $registration->status === 'Pending') {
            return back()->with('error', 'Pendaftaran calon santri ini belum diverifikasi oleh staff. Berkas harus berstatus Diverifikasi terlebih dahulu sebelum disetujui Diterima!');
        }

        $registration->update($validated);

        $actionType = match($validated['status']) {
            'Diverifikasi' => 'PSB_VERIFIKASI',
            'Diterima' => 'PSB_SETUJUI',
            default => 'PSB_UPDATE',
        };

        \App\Services\ActivityLogger::log(
            $actionType,
            'Mengubah status pendaftaran calon santri "' . $registration->nama_lengkap . '" (' . $registration->no_pendaftaran . ') menjadi: ' . $validated['status'] . ($validated['catatan'] ? ' | Catatan: ' . $validated['catatan'] : '')
        );

        return back()->with('success', 'Status pendaftaran ' . $registration->nama_lengkap . ' berhasil diubah menjadi: ' . $validated['status']);
    }

    /**
     * Delete registration (ADMIN ONLY).
     */
    public function destroy(Registration $registration)
    {
        if (!auth()->user()->isAdmin()) {
            return back()->with('error', 'Akses Ditolak: Hanya Administrator yang berhak menghapus berkas pendaftaran santri.');
        }

        $name = $registration->nama_lengkap;
        $noReg = $registration->no_pendaftaran;
        $registration->delete();

        \App\Services\ActivityLogger::log(
            'PSB_HAPUS',
            'Menghapus berkas pendaftaran calon santri: "' . $name . '" (' . $noReg . ')'
        );

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Data pendaftaran santri "' . $name . '" berhasil dihapus.');
    }

    /**
     * Printable Registration Slip.
     */
    public function printSlip(Registration $registration)
    {
        return view('admin.registrations.print', compact('registration'));
    }
}
