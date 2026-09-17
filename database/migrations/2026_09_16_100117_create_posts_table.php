<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedInteger('reading_time')->default(1); // زمان تقریبی مطالعه بر حسب دقیقه
            
            // فیلدهای بهینه‌سازی SEO و متادیتا
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // ایندکس ترکیبی برای بهینه‌سازی حداکثری کوئری مقالات منتشرشده
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
