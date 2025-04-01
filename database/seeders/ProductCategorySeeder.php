<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks before truncating
        Schema::disableForeignKeyConstraints();

        // Clear existing categories
        DB::table('product_categories')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Create parent categories
        $parentCategories = [
            [
                'name' => 'Furniture',
                'subcategories' => [
                    'Sofas & Couches',
                    'Chairs',
                    'Tables',
                    'Beds',
                    'Cabinets'
                ]
            ],
            [
                'name' => 'Lighting',
                'subcategories' => [
                    'Ceiling Lights',
                    'Wall Lights',
                    'Floor Lamps',
                    'Table Lamps',
                    'Outdoor Lighting'
                ]
            ],
            [
                'name' => 'Simba Doors Collections',
                'subcategories' => [
                    'Wooden Doors',
                    'Glass Doors',
                    'Security Doors',
                    'Sliding Doors',
                    'Custom Doors'
                ]
            ],
            [
                'name' => 'Kitchen',
                'subcategories' => [
                    'Cabinets',
                    'Countertops',
                    'Sinks & Faucets',
                    'Appliances',
                    'Kitchen Islands'
                ]
            ],
            [
                'name' => 'Bathroom',
                'subcategories' => [
                    'Vanities',
                    'Toilets',
                    'Showers',
                    'Bathtubs',
                    'Accessories'
                ]
            ],
            [
                'name' => 'Outdoor',
                'subcategories' => [
                    'Patio Furniture',
                    'Garden Tools',
                    'Outdoor Decor',
                    'Grills & Accessories',
                    'Planters'
                ]
            ],
        ];

        foreach ($parentCategories as $parentCategory) {
            $parentSlug = Str::slug($parentCategory['name']);

            $parent = ProductCategory::create([
                'name' => $parentCategory['name'],
                'slug' => $parentSlug,
                'description' => 'This is the ' . $parentCategory['name'] . ' category.',
                'is_active' => true,
                'is_featured' => rand(0, 1) === 1,
                'sort_order' => rand(0, 10),
                'meta_title' => $parentCategory['name'] . ' - Shop Online',
                'meta_description' => 'Browse our collection of high-quality ' . strtolower($parentCategory['name']) . '.',
                'keywords' => [strtolower($parentCategory['name']), 'shop', 'quality'],
                'display_mode' => 'both',
                'products_per_page' => 24,
            ]);

            // Create subcategories
            foreach ($parentCategory['subcategories'] as $index => $subcategoryName) {
                // Create a unique slug by combining parent slug and subcategory name
                $subcategorySlug = $parentSlug . '-' . Str::slug($subcategoryName);

                ProductCategory::create([
                    'parent_id' => $parent->id,
                    'name' => $subcategoryName,
                    'slug' => $subcategorySlug,
                    'description' => 'This is the ' . $subcategoryName . ' subcategory in the ' . $parentCategory['name'] . ' department.',
                    'is_active' => true,
                    'is_featured' => rand(0, 1) === 1,
                    'sort_order' => $index,
                    'meta_title' => $subcategoryName . ' - ' . $parentCategory['name'] . ' Department',
                    'meta_description' => 'Shop for ' . $subcategoryName . ' in our ' . $parentCategory['name'] . ' department.',
                    'keywords' => [strtolower($subcategoryName), strtolower($parentCategory['name']), 'shop'],
                    'display_mode' => 'products',
                    'products_per_page' => 24,
                ]);
            }
        }

        $this->command->info('Product categories and subcategories seeded successfully!');
    }
}
