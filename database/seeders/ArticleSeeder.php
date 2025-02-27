<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Author;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // First ensure we have categories and authors
        $this->call([
            ArticleCategorySeeder::class,
            AuthorSeeder::class,
        ]);

        // Create necessary tags if they don't exist
        $tags = ['Security', 'Tips', 'Design', 'Modern', 'Aluminum', 'Maintenance'];
        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['name' => $tagName],
                ['slug' => Str::slug($tagName)]
            );
        }

        // Make sure we have required categories and authors before proceeding
        $doorDesignsCat = ArticleCategory::where('slug', 'door-designs')->first();
        $windowSolutionsCat = ArticleCategory::where('slug', 'window-solutions')->first();
        $johnSmith = Author::where('slug', 'john-smith')->first();
        $sarahWilson = Author::where('slug', 'sarah-wilson')->first();

        if (!$doorDesignsCat || !$windowSolutionsCat || !$johnSmith || !$sarahWilson) {
            throw new \Exception('Required categories or authors not found. Please run category and author seeders first.');
        }

        $articles = [
            [
                'article_category_id' => $doorDesignsCat->id,
                'author_id' => $johnSmith->id,
                'title' => 'Top Security Door Features for Your Home',
                'slug' => 'top-security-door-features-for-your-home',
                'excerpt' => 'Discover the essential security features that every home security door should have to keep your property safe.',
                'content' => "# Essential Security Door Features\n\nWhen it comes to protecting your home, security doors are your first line of defense...",
                'featured_image' => 'blog/articles/security-door-features.jpg',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
                'meta_title' => 'Essential Security Door Features for Home Protection',
                'meta_description' => 'Learn about the most important security features for your home\'s doors. Expert advice on choosing secure doors.',
                'keywords' => json_encode(['security doors', 'door security', 'home protection']),
                'reading_time' => 5,
                'tags' => ['Security', 'Tips', 'Design']
            ],
            [
                'article_category_id' => $windowSolutionsCat->id,
                'author_id' => $sarahWilson->id,
                'title' => 'Modern Window Designs for Contemporary Homes',
                'slug' => 'modern-window-designs-for-contemporary-homes',
                'excerpt' => 'Explore the latest trends in window design and how they can enhance your modern home\'s aesthetic.',
                'content' => "# Contemporary Window Trends\n\nModern window designs are revolutionizing how we think about natural light...",
                'featured_image' => 'blog/articles/modern-windows.jpg',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(4),
                'meta_title' => 'Contemporary Window Designs for Modern Homes',
                'meta_description' => 'Discover modern window design trends and ideas for contemporary homes.',
                'keywords' => json_encode(['window design', 'modern windows', 'contemporary design']),
                'reading_time' => 6,
                'tags' => ['Design', 'Modern', 'Aluminum']
            ]
        ];

        foreach ($articles as $articleData) {
            $this->createArticle($articleData);
        }
    }

    private function createArticle(array $data): void
    {
        // Extract tags
        $tagNames = $data['tags'] ?? [];
        unset($data['tags']);

        // Create article
        $article = Article::create($data);

        // Attach tags
        if (!empty($tagNames)) {
            $tags = Tag::whereIn('name', $tagNames)->get();
            $article->tags()->attach($tags);
        }
    }
}
