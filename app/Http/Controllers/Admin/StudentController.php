<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

class StudentController extends Controller
{
    /**
     * Build base query for accepted/active students.
     */
    protected function buildStudentQuery(Request $request)
    {
        $query = Registration::where('status', 'Diterima');

        // Search filter
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$q}%")
                    ->orWhere('nisn', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('no_wa', 'like', "%{$q}%")
                    ->orWhere('asal_sekolah', 'like', "%{$q}%")
                    ->orWhere('nama_wali', 'like', "%{$q}%");
            });
        }

        // Jenjang filter
        if ($request->filled('jenjang')) {
            $query->where('pilihan_jenjang', 'like', "%{$request->jenjang}%");
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        return $query;
    }

    /**
     * Display a listing of accepted/active students.
     */
    public function index(Request $request)
    {
        $query = $this->buildStudentQuery($request);
        $students = $query->orderBy('updated_at', 'desc')->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total' => Registration::where('status', 'Diterima')->count(),
            'putra' => Registration::where('status', 'Diterima')->where('jenis_kelamin', 'Laki-laki')->count(),
            'putri' => Registration::where('status', 'Diterima')->where('jenis_kelamin', 'Perempuan')->count(),
            'mts'   => Registration::where('status', 'Diterima')->where('pilihan_jenjang', 'like', '%MTS%')->count(),
            'ma'    => Registration::where('status', 'Diterima')->where('pilihan_jenjang', 'like', '%MA%')->count(),
        ];

        return view('admin.students.index', compact('students', 'stats'));
    }

    /**
     * Export students data to Excel-compatible CSV.
     */
    public function exportExcel(Request $request)
    {
        $students = $this->buildStudentQuery($request)->orderBy('nama_lengkap', 'asc')->get();

        $filename = 'Data-Santri-PP-Nurussyam-' . date('Ymd-His') . '.csv';

        \App\Services\ActivityLogger::log(
            'SANTRI_EKSPOR',
            'Mengekspor ' . $students->count() . ' data santri aktif ke file Excel/CSV.'
        );

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM so Excel opens it with proper UTF-8 encoding
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'No',
                'No. Induk / Registrasi',
                'Nama Lengkap Santri',
                'NISN',
                'NIK',
                'Jenis Kelamin',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Pilihan Jenjang',
                'Nama Orang Tua / Wali',
                'No. WhatsApp',
                'Asal Sekolah',
                'Alamat Lengkap',
                'Status Santri',
                'Tanggal Masuk / Diterima',
                'Catatan',
            ]);

            $no = 1;
            foreach ($students as $st) {
                fputcsv($file, [
                    $no++,
                    $st->no_pendaftaran,
                    $st->nama_lengkap,
                    $st->nisn ? "'" . $st->nisn : '-',
                    $st->nik ? "'" . $st->nik : '-',
                    $st->jenis_kelamin,
                    $st->tempat_lahir ?? '-',
                    $st->tanggal_lahir ? "'" . $st->tanggal_lahir->format('d/m/Y') : '-',
                    str_replace('Salafiyah', "Ma'had Nurussyam", $st->pilihan_jenjang),
                    $st->nama_wali ?? '-',
                    $st->no_wa ? "'" . $st->no_wa : '-',
                    $st->asal_sekolah ?? '-',
                    $st->alamat ?? '-',
                    $st->status,
                    $st->updated_at ? "'" . $st->updated_at->format('d/m/Y H:i') : '-',
                    $st->catatan ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display printable official summary document of active students (Hard File / PDF ready).
     */
    public function printRekap(Request $request)
    {
        $students = $this->buildStudentQuery($request)->orderBy('nama_lengkap', 'asc')->get();

        $stats = [
            'total' => $students->count(),
            'putra' => $students->where('jenis_kelamin', 'Laki-laki')->count(),
            'putri' => $students->where('jenis_kelamin', 'Perempuan')->count(),
            'mts'   => $students->filter(fn($s) => stripos($s->pilihan_jenjang, 'MTS') !== false)->count(),
            'ma'    => $students->filter(fn($s) => stripos($s->pilihan_jenjang, 'MA') !== false)->count(),
        ];

        $filterInfo = [
            'q' => $request->q,
            'jenjang' => $request->jenjang,
            'gender' => $request->gender,
        ];

        \App\Services\ActivityLogger::log(
            'SANTRI_CETAK_REKAP',
            'Membuka lembar cetak fisik (hard file) rekapitulasi data santri aktif (' . $students->count() . ' data).'
        );

        return view('admin.students.print-rekap', compact('students', 'stats', 'filterInfo'));
    }

    /**
     * Show the form for creating a new student manually.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'nisn'            => 'nullable|string|max:50',
            'nik'             => 'nullable|string|max:50',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'    => 'nullable|string|max:100',
            'tanggal_lahir'   => 'nullable|date',
            'nama_wali'       => 'required|string|max:255',
            'no_wa'           => 'required|string|max:30',
            'alamat'          => 'required|string',
            'asal_sekolah'    => 'nullable|string|max:255',
            'pilihan_jenjang' => 'required|string|max:100',
            'catatan'         => 'nullable|string',
        ]);

        $cleanNama = mb_strtolower(preg_replace('/\s+/', ' ', trim($validated['nama_lengkap'])));
        $existing = Registration::whereRaw('LOWER(TRIM(nama_lengkap)) = ?', [$cleanNama])->first();
        if ($existing) {
            return back()->withInput()->withErrors([
                'nama_lengkap' => "Data santri dengan nama '{$validated['nama_lengkap']}' sudah ada di database (No: {$existing->no_pendaftaran}, Status: {$existing->status})."
            ]);
        }

        // Auto generate No Induk Santri (Guaranteed Unique)
        $validated['no_pendaftaran'] = Registration::generateNoPendaftaran('SNTR');
        $validated['status'] = 'Diterima';

        $newStudent = Registration::create($validated);

        \App\Services\ActivityLogger::log(
            'SANTRI_TAMBAH',
            'Menambahkan data santri aktif baru: "' . $newStudent->nama_lengkap . '" (No. Induk: ' . $newStudent->no_pendaftaran . ', Jenjang: ' . $newStudent->pilihan_jenjang . ')'
        );

        return redirect()->route('admin.students.index')
            ->with('success', "Santri {$validated['nama_lengkap']} berhasil ditambahkan ke Data Santri Aktif!");
    }

    /**
     * Display the specified student.
     */
    public function show(Registration $student)
    {
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Registration $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Registration $student)
    {
        $validated = $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'nisn'            => 'nullable|string|max:50',
            'nik'             => 'nullable|string|max:50',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'    => 'nullable|string|max:100',
            'tanggal_lahir'   => 'nullable|date',
            'nama_wali'       => 'required|string|max:255',
            'no_wa'           => 'required|string|max:30',
            'alamat'          => 'required|string',
            'asal_sekolah'    => 'nullable|string|max:255',
            'pilihan_jenjang' => 'required|string|max:100',
            'catatan'         => 'nullable|string',
        ]);

        $student->update($validated);

        \App\Services\ActivityLogger::log(
            'SANTRI_EDIT',
            'Memperbarui data santri aktif: "' . $student->nama_lengkap . '" (' . $student->no_pendaftaran . ')'
        );

        return redirect()->route('admin.students.index')
            ->with('success', "Data santri {$student->nama_lengkap} berhasil diperbarui!");
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Registration $student)
    {
        $name = $student->nama_lengkap;
        $noInduk = $student->no_pendaftaran;
        $student->delete();

        \App\Services\ActivityLogger::log(
            'SANTRI_HAPUS',
            'Menghapus data santri aktif: "' . $name . '" (' . $noInduk . ')'
        );

        return redirect()->route('admin.students.index')
            ->with('success', "Data santri {$name} berhasil dihapus.");
    }

    /**
     * Print official Student Card / Biodata Santri Aktif.
     */
    public function printCard(Registration $student)
    {
        return view('admin.students.card', compact('student'));
    }
}
