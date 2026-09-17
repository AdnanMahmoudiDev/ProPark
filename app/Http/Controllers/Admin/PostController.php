<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * نمایش لیست مقالات با قابلیت فیلتر و جستجو
     */
    public function index(Request $request)
    {
        $query = Post::query()
            ->with(['category', 'author']) // رابطه استاندارد شما: author()
            ->latest();

        // فیلتر بر اساس وضعیت
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // فیلتر بر اساس دسته‌بندی
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // جستجو در عنوان/خلاصه
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * فرم ایجاد مقاله جدید
     */
    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * ذخیره مقاله جدید در دیتابیس
     */
    public function store(Request $request)
    {
        $validated = $this->validatePost($request);

        $data = $this->preparePostData($request, $validated);

        // مهم: جدول posts ستون author_id دارد و اجباری است
        $data['author_id'] = auth()->id();

        // تنظیم تاریخ انتشار
        if (($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'مقاله با موفقیت ایجاد و ذخیره شد.');
    }

    /**
     * فرم ویرایش مقاله
     */
    public function edit(Post $post)
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * به‌روزرسانی مقاله
     */
    public function update(Request $request, Post $post)
    {
        $validated = $this->validatePost($request, $post);

        $data = $this->preparePostData($request, $validated, $post);

        // اگر مقاله برای اولین بار published شد و تاریخ انتشار ندارد
        if (($data['status'] ?? $post->status) === 'published' && empty($post->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'تغییرات مقاله با موفقیت ذخیره شد.');
    }

    /**
     * حذف مقاله
     */
    public function destroy(Post $post)
    {
        if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'مقاله با موفقیت حذف شد.');
    }

    /**
     * اندپوینت آپلود تصاویر درون ادیتور TinyMCE
     */
    public function uploadContentImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,webp,gif|max:5120',
        ]);

        $path = $request->file('file')->store('blog/content', 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
        ]);
    }

    /**
     * Validation Rules (سازگار با فیلدهای جدید/قدیم)
     */
    private function validatePost(Request $request, ?Post $post = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:posts,slug';
        if ($post) {
            $slugRule .= ',' . $post->id;
        }

        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => $slugRule,

            // اگر در دیتابیس category_id NOT NULL است، این را required کن.
            'category_id' => 'nullable|exists:categories,id',

            'content' => 'required|string',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',

            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'canonical_url' => 'nullable|url|max:255',

            // فیلدهای جدید (مدل فعلی)
            'excerpt' => 'nullable|string|max:500',
            'seo_title' => 'nullable|string|max:70',
            'seo_description' => 'nullable|string|max:160',

            // فیلدهای قدیمی (برای سازگاری با فرم‌های قبلی)
            'summary' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
        ]);
    }

    /**
     * آماده‌سازی داده‌ها مطابق ستون‌های واقعی جدول posts
     */
    private function preparePostData(Request $request, array $validated, ?Post $post = null): array
    {
        // excerpt (ترجیح: excerpt سپس summary)
        $excerpt = $validated['excerpt'] ?? ($validated['summary'] ?? null);
        if (empty($excerpt)) {
            $excerpt = Str::limit(trim(strip_tags($validated['content'])), 180, '...');
        }

        // SEO fields (ترجیح: seo_* سپس meta_*)
        $seoTitle = $validated['seo_title'] ?? ($validated['meta_title'] ?? null);
        $seoDescription = $validated['seo_description'] ?? ($validated['meta_description'] ?? null);

        // Slug
        $rawSlug = $validated['slug'] ?? null;
        if (empty($rawSlug)) {
            $slug = $post ? $post->slug : $this->generateUniqueSlug($validated['title']);
        } else {
            if (!$post || $rawSlug !== $post->slug) {
                $slug = $this->generateUniqueSlug($rawSlug, $post?->id);
            } else {
                $slug = $post->slug;
            }
        }

        $data = [
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $validated['category_id'] ?? null,
            'content' => $validated['content'],
            'excerpt' => $excerpt,
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,

            'seo_title' => $seoTitle ?: Str::limit($validated['title'], 65, ''),
            'seo_description' => $seoDescription ?: Str::limit($excerpt, 155, ''),
            'canonical_url' => $validated['canonical_url'] ?? null,

            'reading_time' => $this->calculateReadingTime($validated['content']),
        ];

        // Upload featured image (و حذف قبلی در حالت update)
        if ($request->hasFile('featured_image')) {
            if ($post && $post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $data['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        return $data;
    }

    /**
     * محاسبه زمان مطالعه بر حسب دقیقه
     */
    private function calculateReadingTime(string $htmlContent): int
    {
        $text = strip_tags($htmlContent);

        preg_match_all('/[\p{L}\p{N}]+/u', $text, $matches);
        $wordCount = count($matches[0] ?? []);

        return max(1, (int) ceil($wordCount / 180));
    }

    /**
     * ساخت اسلاگ یکتا با پشتیبانی از یونیکد
     */
    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = trim(
            preg_replace('/[^\p{L}\p{N}]+/u', '-', mb_strtolower($title)),
            '-'
        );

        if ($slug === '') {
            $slug = 'post-' . Str::lower(Str::random(6));
        }

        $original = $slug;
        $count = 1;

        while (
            Post::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }
}
