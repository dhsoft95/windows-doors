<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'article_category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'is_featured',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
        'keywords',
        'reading_time',
        'view_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'keywords' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\Author::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getIsPublishedAttribute($value)
    {
        // If published_at is in the future, the article is scheduled
        if ($this->published_at && $this->published_at->isFuture()) {
            return false;
        }

        return $value;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()
            ->orderBy('published_at', 'desc')
            ->limit($limit);
    }

    public function scopePopular($query, $limit = 5)
    {
        return $query->published()
            ->orderBy('view_count', 'desc')
            ->limit($limit);
    }

    // Fixed method to handle possible array issue
    public function incrementViewCount()
    {
        // Get the current model
        $article = self::find($this->id);

        // Do a manual increment instead of using the increment() method
        // which might cause issues with JSON casting
        $article->view_count = ($article->view_count ?? 0) + 1;
        $article->save();

        // Update the current instance
        $this->view_count = $article->view_count;

        return $this;
    }

    public function calculateReadingTime()
    {
        // Average reading speed: 200 words per minute
        $wordCount = str_word_count(strip_tags($this->content));
        $this->reading_time = ceil($wordCount / 200);
        return $this;
    }
}
