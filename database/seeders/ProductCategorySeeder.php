<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Security Doors',
                'slug' => 'security-doors',
                'description' => 'Our designed security doors address high security concerns while responding to functional and sensational artistic needs for residences and other buildings.',
                'image' => 'categories/security-doors.jpg',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'meta_title' => 'Premium Security Doors | Simba Doors and Windows',
                'meta_description' => 'Discover our range of high-security doors that combine safety with elegant design. Perfect for homes and businesses in Tanzania.',
                'keywords' => json_encode(['security doors', 'safety doors', 'steel doors', 'metal doors', 'entrance doors']),
                'display_mode' => 'products',
                'products_per_page' => 12
            ],
            [
                'name' => 'Wood & Metal Interior Doors',
                'slug' => 'interior-doors',
                'description' => 'Our metal and wooden doors are waterproof, solid, laminated, and oven painted, coming with a full frame, handle, lock, hinges, and cylinders.',
                'image' => 'categories/interior-doors.jpg',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'meta_title' => 'Interior Doors - Wood & Metal | Simba Doors and Windows',
                'meta_description' => 'Quality interior doors in wood and metal finishes. Complete with frames, handles, and hardware. Perfect for residential and commercial use.',
                'keywords' => json_encode(['wooden doors', 'metal doors', 'interior doors', 'bedroom doors', 'bathroom doors']),
                'display_mode' => 'products',
                'products_per_page' => 12
            ],
            [
                'name' => 'Aluminum Doors & Windows',
                'slug' => 'aluminum-solutions',
                'description' => 'Our aluminum windows and doors are engineered profiles made from pure aluminum and thick safety glass.',
                'image' => 'categories/aluminum-solutions.jpg',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
                'meta_title' => 'Aluminum Doors & Windows | Simba Doors and Windows',
                'meta_description' => 'Premium aluminum doors and windows with safety glass. Energy-efficient solutions for modern buildings in Tanzania.',
                'keywords' => json_encode(['aluminum windows', 'aluminum doors', 'sliding windows', 'casement windows', 'safety glass']),
                'display_mode' => 'products',
                'products_per_page' => 12
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
