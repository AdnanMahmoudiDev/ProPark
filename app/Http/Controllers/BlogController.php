<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * نمایش لیست مقالات وبلاگ (با فیلتر جستجو و دسته‌بندی)
     */
    public function index(Request $request)
    {
        $query = Post::query()
            ->published()
            ->with(['category', 'author'])
            ->latest('published_at');

        // فیلتر بر اساس دسته‌بندی
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // فیلتر جستجو در عنوان و چکیده
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = Category::withCount(['posts' => function ($q) {
            $q->published();
        }])->having('posts_count', '>', 0)->get();

        $featuredPost = null;
        // اگر در صفحه اول بودیم و فیلتری اعمال نشده بود، اولین پست را به عنوان شاخص برمی‌داریم
        if ($posts->currentPage() === 1 && !$request->filled('search') && !$request->filled('category')) {
            $featuredPost = $posts->first();
        }

        return view('blog.index', compact('posts', 'categories', 'featuredPost'));
    }

    /**
     * نمایش تکی مقاله همراه با سئو، شمارش بازدید و مقالات مرتبط
     */
    public function show(string $slug)
    {
        $post = Post::query()
            ->published()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        // جلوگیری از ثبت بازدید تکراری در یک نشست (Session)
        $sessionKey = 'viewed_post_' . $post->id;
        if (!session()->has($sessionKey)) {
            $post->increment('views_count');
            session()->put($sessionKey, true);
        }

        // دریافت مقالات مرتبط بر اساس دسته‌بندی
        $relatedPosts = Post::query()
            ->published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
