<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Door Designs',
                'slug' => 'door-designs',
                'description' => 'Explore the latest trends and innovations in door designs for your home and office.',
                'image' => 'blog/categories/door-designs.jpg',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'meta_title' => 'Door Design Ideas & Trends | Simba Doors Blog',
                'meta_description' => 'Discover the latest door design trends, styles, and ideas for your home or office. Expert advice on choosing the perfect door.',
                'keywords' => json_encode(['door design', 'door styles', 'modern doors', 'security doors', 'interior doors']),
            ],
            [
                'name' => 'Window Solutions',
                'slug' => 'window-solutions',
                'description' => 'Expert advice on choosing and maintaining windows for optimal functionality and style.',
                'image' => 'blog/categories/window-solutions.jpg',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'meta_title' => 'Window Solutions & Ideas | Simba Doors Blog',
                'meta_description' => 'Find expert advice on window solutions, maintenance tips, and style guides for your property.',
                'keywords' => json_encode(['window solutions', 'window styles', 'aluminum windows', 'window maintenance']),
            ],
            [
                'name' => 'Security Tips',
                'slug' => 'security-tips',
                'description' => 'Enhance your property security with expert advice and proven security solutions.',
                'image' => 'blog/categories/security-tips.jpg',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'meta_title' => 'Home & Office Security Tips | Simba Doors Blog',
                'meta_description' => 'Learn about improving your property security with expert tips and advice on security doors and windows.',
                'keywords' => json_encode(['security tips', 'home security', 'door security', 'window security']),
            ],
            [
                'name' => 'Maintenance Guides',
                'slug' => 'maintenance-guides',
                'description' => 'Comprehensive guides on maintaining and caring for your doors and windows.',
                'image' => 'blog/categories/maintenance-guides.jpg',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'meta_title' => 'Door & Window Maintenance Guides | Simba Doors Blog',
                'meta_description' => 'Step-by-step maintenance guides for doors and windows. Tips for extending the life of your installations.',
                'keywords' => json_encode(['maintenance guide', 'door maintenance', 'window maintenance', 'care tips']),
            ],
            [
                'name' => 'Installation Tips',
                'slug' => 'installation-tips',
                'description' => 'Professional insights into proper door and window installation procedures.',
                'image' => 'blog/categories/installation-tips.jpg',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
                'meta_title' => 'Door & Window Installation Tips | Simba Doors Blog',
                'meta_description' => 'Expert tips on door and window installation. Learn about best practices and common mistakes to avoid.',
                'keywords' => json_encode(['installation tips', 'door installation', 'window installation', 'professional tips']),
            ]
        ];

        foreach ($categories as $category) {
            ArticleCategory::firstOrCreate(
                ['slug' => $category['slug']], // Check if exists by slug
                $category // Data to create if doesn't exist
            );
        }
    }
}
