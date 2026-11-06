<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display categories.
     */
    public function index()
    {
        $categories = Category::withCount('articles')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store new category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:300',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . (++$counter);
        }

        $category = Category::create([
            'name' => strtoupper($validated['name']),
            'slug' => $slug,
            'color' => $validated['color'] ?: '#0f8528',
            'description' => $validated['description'] ?? null,
        ]);

        \App\Services\ActivityLogger::log('KATEGORI_TAMBAH', "Menambahkan kategori berita baru: \"{$category->name}\"");

        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Update category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:300',
        ]);

        $category->name = strtoupper($validated['name']);
        $category->color = $validated['color'] ?: $category->color;
        $category->description = $validated['description'] ?? $category->description;
        $category->save();

        \App\Services\ActivityLogger::log('KATEGORI_EDIT', "Memperbarui kategori berita: \"{$category->name}\"");

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove category.
     */
    public function destroy(Category $category)
    {
        if ($category->articles()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori karena masih memiliki ' . $category->articles()->count() . ' artikel terkait.');
        }

        $nama = $category->name;
        $category->delete();

        \App\Services\ActivityLogger::log('KATEGORI_HAPUS', "Menghapus kategori berita: \"{$nama}\"");

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
