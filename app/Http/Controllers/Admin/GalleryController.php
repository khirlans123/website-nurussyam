<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Gallery;
use App\Models\Article;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery items (Manual uploads + Auto-synced from articles).
     */
    public function index(Request $request)
    {
        $query = Gallery::query()->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $galleries = $query->paginate(12)->withQueryString();

        // Foto-foto kegiatan yang otomatis diambil dari berita santri yang sudah terbit
        $autoArticlePhotos = Article::where('is_published', true)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderBy('id', 'desc')
            ->get();

        $categories = Gallery::select('category')->distinct()->whereNotNull('category')->pluck('category');

        return view('admin.galleries.index', compact('galleries', 'autoArticlePhotos', 'categories'));
    }

    /**
     * Show the form for creating a new gallery item.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created gallery item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'activity_date' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul foto kegiatan wajib diisi.',
            'image_file.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'image_file.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        if (!$request->hasFile('image_file') && empty($validated['image_url'])) {
            return back()->withInput()->withErrors(['image_file' => 'Silakan pilih file foto atau masukkan URL gambar.']);
        }

        $imagePath = 'images/article1.jpg';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadDir = public_path('uploads/galleries');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }
            $cleanName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = 'gallery_' . time() . '_' . $cleanName . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $imagePath = 'uploads/galleries/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        Gallery::create([
            'title' => trim($validated['title']),
            'image' => $imagePath,
            'category' => !empty($validated['category']) ? trim($validated['category']) : 'Kegiatan Santri',
            'activity_date' => $validated['activity_date'] ?? date('d F Y'),
            'description' => $validated['description'] ?? null,
            'is_published' => $request->has('is_published') ? (bool) $request->input('is_published') : true,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto kegiatan berhasil ditambahkan ke Galeri Pesantren!');
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery item in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'activity_date' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
        ]);

        $imagePath = $gallery->image;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadDir = public_path('uploads/galleries');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }

            // Hapus file lama jika ada di uploads/galleries
            if ($gallery->image && str_starts_with($gallery->image, 'uploads/galleries/') && File::exists(public_path($gallery->image))) {
                File::delete(public_path($gallery->image));
            }

            $cleanName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = 'gallery_' . time() . '_' . $cleanName . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $imagePath = 'uploads/galleries/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        $gallery->update([
            'title' => trim($validated['title']),
            'image' => $imagePath,
            'category' => !empty($validated['category']) ? trim($validated['category']) : 'Kegiatan Santri',
            'activity_date' => $validated['activity_date'] ?? $gallery->activity_date,
            'description' => $validated['description'] ?? null,
            'is_published' => $request->has('is_published') ? (bool) $request->input('is_published') : $gallery->is_published,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Data foto kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified gallery item from storage.
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && str_starts_with($gallery->image, 'uploads/galleries/') && File::exists(public_path($gallery->image))) {
            File::delete(public_path($gallery->image));
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Foto kegiatan berhasil dihapus dari galeri.');
    }

    /**
     * Toggle published status.
     */
    public function togglePublish(Gallery $gallery)
    {
        $gallery->is_published = !$gallery->is_published;
        $gallery->save();

        $statusStr = $gallery->is_published ? 'ditampilkan' : 'disembunyikan';
        return redirect()->back()->with('success', "Foto kegiatan berhasil {$statusStr} di website publik!");
    }
}
