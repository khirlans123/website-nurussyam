<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request)
    {
        $query = Article::query()->with('categoryRel')->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        $articles = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'author' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:600',
            'content' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image_url' => 'nullable|string|max:500',
            'date' => 'nullable|string|max:100',
            'activity_time' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:30',
            'read_time' => 'nullable|string|max:50',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        // Generate Unique Slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . (++$counter);
        }

        // Handle Image
        $imagePath = 'images/article1.jpg'; // default fallback
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadDir = public_path('uploads/articles');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }
            $filename = $this->processAndCompressImage($file, $uploadDir, pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $imagePath = 'uploads/articles/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        // Category association
        $categoryName = 'BERITA';
        $badgeColor = $validated['badge_color'] ?? '#0f8528';
        if (!empty($validated['category_id'])) {
            $cat = Category::find($validated['category_id']);
            if ($cat) {
                $categoryName = $cat->name;
                if (empty($validated['badge_color'])) {
                    $badgeColor = $cat->color;
                }
            }
        }

        // Estimated Read Time
        $readTime = $validated['read_time'];
        if (empty($readTime)) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $minutes = max(1, ceil($wordCount / 180));
            $readTime = $minutes . ' menit baca';
        }

        // Summary Fallback
        $summary = $validated['summary'];
        if (empty($summary)) {
            $summary = Str::limit(strip_tags($validated['content']), 160);
        }

        // Tanggal & Jam Up Berita / Kegiatan
        $dateFormatted = !empty($validated['date'])
            ? trim($validated['date'])
            : now()->locale('id')->isoFormat('D MMMM Y');

        $timeFormatted = !empty($validated['activity_time'])
            ? trim($validated['activity_time'])
            : now()->format('H:i') . ' WIB';

        $article = Article::create([
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $categoryName,
            'author' => $validated['author'] ?: (Auth::user()?->name ?? 'Admin Nurussyam'),
            'date' => $dateFormatted,
            'activity_time' => $timeFormatted,
            'image' => $imagePath,
            'badge_color' => $badgeColor,
            'read_time' => $readTime,
            'summary' => $summary,
            'content' => $validated['content'],
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published', true),
            'views_count' => 0,
            'comments_count' => 0,
        ]);

        \App\Services\ActivityLogger::log(
            'ARTIKEL_CREATE',
            'Menulis & mengunggah berita baru: "' . $article->title . '" (Kategori: ' . $article->category . ', Penulis: ' . $article->author . ')'
        );

        return redirect()->route('admin.articles.index')
            ->with('success', 'Berita berhasil dipublikasikan!');
    }

    /**
     * Show the form for editing an article.
     */
    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'category_id' => 'nullable|exists:categories,id',
            'author' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:600',
            'content' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image_url' => 'nullable|string|max:500',
            'date' => 'nullable|string|max:100',
            'activity_time' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:30',
            'read_time' => 'nullable|string|max:50',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'image_file.image' => 'File harus berupa gambar valid.',
        ]);

        // Slug
        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        if ($slug !== $article->slug) {
            $baseSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $baseSlug . '-' . (++$counter);
            }
            $article->slug = $slug;
        }

        // Image Handling
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadDir = public_path('uploads/articles');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }
            $filename = $this->processAndCompressImage($file, $uploadDir, pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

            // Clean previous uploaded image if stored locally in uploads/articles
            if ($article->image && str_starts_with($article->image, 'uploads/articles/') && File::exists(public_path($article->image))) {
                @unlink(public_path($article->image));
            }

            $article->image = 'uploads/articles/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $article->image = $validated['image_url'];
        }

        // Category
        if (!empty($validated['category_id'])) {
            $cat = Category::find($validated['category_id']);
            if ($cat) {
                $article->category_id = $cat->id;
                $article->category = $cat->name;
            }
        } else {
            $article->category_id = null;
        }

        $article->title = $validated['title'];
        $article->author = $validated['author'] ?: $article->author;
        $article->summary = $validated['summary'] ?: Str::limit(strip_tags($validated['content']), 160);
        $article->content = $validated['content'];
        $article->badge_color = $validated['badge_color'] ?: $article->badge_color;
        $article->read_time = $validated['read_time'] ?: $article->read_time;
        if ($request->filled('date')) {
            $article->date = trim($validated['date']);
        }
        if ($request->filled('activity_time')) {
            $article->activity_time = trim($validated['activity_time']);
        }
        $article->is_featured = $request->boolean('is_featured');
        $article->is_published = $request->boolean('is_published');

        $article->save();

        \App\Services\ActivityLogger::log('ARTIKEL_UPDATE', 'Memperbarui data berita: "' . $article->title . '"');

        return redirect()->route('admin.articles.index')
            ->with('success', 'Berita "' . $article->title . '" berhasil diperbarui.');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        $title = $article->title;

        // Clean image if inside uploads/articles
        if ($article->image && str_starts_with($article->image, 'uploads/articles/') && File::exists(public_path($article->image))) {
            @unlink(public_path($article->image));
        }

        $article->delete();

        \App\Services\ActivityLogger::log('ARTIKEL_DELETE', 'Menghapus berita: "' . $title . '"');

        return redirect()->route('admin.articles.index')
            ->with('success', 'Berita "' . $title . '" berhasil dihapus.');
    }

    /**
     * Toggle publish state.
     */
    public function togglePublish(Article $article)
    {
        $article->is_published = !$article->is_published;
        $article->save();

        $status = $article->is_published ? 'dipublikasikan' : 'dijadikan draft';

        \App\Services\ActivityLogger::log('ARTIKEL_STATUS', 'Mengubah status publikasi berita "' . $article->title . '" menjadi: ' . $status);

        return back()->with('success', 'Status berita berhasil ' . $status . '.');
    }

    /**
     * Toggle featured state.
     */
    public function toggleFeatured(Article $article)
    {
        $article->is_featured = !$article->is_featured;
        $article->save();

        $status = $article->is_featured ? 'dijadikan Berita Utama' : 'dihapus dari Berita Utama';

        \App\Services\ActivityLogger::log('ARTIKEL_STATUS', 'Mengubah status sorotan berita "' . $article->title . '" (' . $status . ')');

        return back()->with('success', 'Berita berhasil ' . $status . '.');
    }

    /**
     * Resize and compress uploaded images to optimize web performance.
     */
    protected function processAndCompressImage($file, $uploadDir, $baseName): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $safeName = Str::slug($baseName) ?: 'article_img';
        $filename = time() . '_' . $safeName . '.' . ($ext === 'png' ? 'png' : ($ext === 'webp' ? 'webp' : 'jpg'));
        $destination = $uploadDir . DIRECTORY_SEPARATOR . $filename;

        $filePath = $file->getRealPath();
        $imgInfo = @getimagesize($filePath);

        if (!$imgInfo || !function_exists('imagecreatefromstring')) {
            $file->move($uploadDir, $filename);
            return $filename;
        }

        $width = $imgInfo[0];
        $height = $imgInfo[1];
        $mime = $imgInfo['mime'] ?? '';

        $src = null;
        if ($mime === 'image/jpeg') {
            $src = @imagecreatefromjpeg($filePath);
        } elseif ($mime === 'image/png') {
            $src = @imagecreatefrompng($filePath);
        } elseif ($mime === 'image/webp') {
            $src = @imagecreatefromwebp($filePath);
        }

        if (!$src) {
            $file->move($uploadDir, $filename);
            return $filename;
        }

        // Resize if width > 1200px
        $maxWidth = 1200;
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($height / $width) * $newWidth);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        if ($mime === 'image/png') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if ($mime === 'image/png') {
            imagepng($dst, $destination, 8);
        } elseif ($mime === 'image/webp') {
            imagewebp($dst, $destination, 82);
        } else {
            imagejpeg($dst, $destination, 82);
        }

        imagedestroy($src);
        imagedestroy($dst);

        return $filename;
    }
}
