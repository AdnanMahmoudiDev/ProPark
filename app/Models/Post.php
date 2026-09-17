<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'views_count',
        'reading_time',
        'seo_title',
        'seo_description',
        'canonical_url',
        'og_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'reading_time' => 'integer',
    ];

    // --- روابط (Relationships) ---
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // --- اسکوپ‌ها (Query Scopes) ---

    /**
     * اسکوپ برای دریافت مقالات منتشر شده که تاریخ انتشار آن‌ها فرارسیده است
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    // --- Accessors & Helpers (سئو و زمان مطالعه) ---

    /**
     * دریافت عنوان سئو با Fallback به عنوان اصلی مقاله
     */
    public function getDisplaySeoTitleAttribute(): string
    {
        return !empty($this->seo_title) ? $this->seo_title : $this->title;
    }

    /**
     * دریافت توضیحات سئو با Fallback به چکیده مقاله
     */
    public function getDisplaySeoDescriptionAttribute(): ?string
    {
        if (!empty($this->seo_description)) {
            return $this->seo_description;
        }
        return $this->excerpt;
    }

    /**
     * محاسبه زمان تقریبی مطالعه بر حسب دقیقه (فرض میانگین ۲۰۰ کلمه در دقیقه)
     */
    public static function calculateReadingTime(?string $content): int
    {
        if (empty($content)) {
            return 1;
        }

        $cleanText = strip_tags($content);
        $wordCount = count(preg_split('/\s+/u', trim($cleanText)));
        $minutes = (int) ceil($wordCount / 200);

        return max(1, $minutes);
    }
}
