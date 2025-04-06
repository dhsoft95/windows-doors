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
                'name' => 'ENTRANCE SECURITY DOORS',
                'subcategories' => [
                    'Hi-Tech 8000',
                    'Model SUPREME 7000',
                    'ART 5000',
                    'CHIC 3000'
                ],
                'descriptions' => [
                    'Hi-Tech 8000' => 'The Ultimate Blend of Security & Style. Our Hi-Tech Series doors are designed to offer exceptional security, durability, and aesthetic appeal. Constructed with a robust steel core, these doors provide unmatched strength while allowing you to customize the exterior finish to suit your style. Choose from a range of premium materials, including glass, concrete, aluminum, wood-look, oven-painted steel, and more. Advanced Security with four massive bolts, Enhanced Insulation, and Sophisticated Design.',

                    'Model SUPREME 7000' => 'Designed Entry Doors with a Mediterranean-inspired design and a unique, authentic appearance. The SUPREME series of security doors includes a selection of doors with an exceptionally high level of safety, conforming to five quality standards. This series includes a choice of designed front doors with aluminum decorative elements and barred windows. Available with prestigious electrostatic painted finishes in a wide range of shades of granular epoxy paints.',

                    'ART 5000' => 'Timeless Artistic Security Doors. For those who admire the grandeur of ancient European castles, the ART 5000 Series is the perfect blend of security, artistry, and heritage. Inspired by ancient art, this unique collection of security doors showcases handcrafted blacksmith-designed elements, adding an unparalleled touch of elegance and strength. Each door is finished with a special coloring technique, creating an authentic aged appearance that enhances its historic charm.',

                    'CHIC 3000' => 'Designed Door Series crafted for those who appreciate sophisticated aesthetics and superior security. With its minimalist yet elegant design, this series brings a refined and modern touch to any home or commercial entrance. Each door is continuously enhanced with new models, featuring built-in or attached nickel strips for a sleek, contemporary look. Offers exceptional thermal and acoustic insulation, ensuring comfort, energy efficiency, and noise reduction.'
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
                'is_featured' => true,
                'sort_order' => 1,
                'meta_title' => $parentCategory['name'] . ' - Shop Online',
                'meta_description' => 'Browse our collection of high-quality ' . strtolower($parentCategory['name']) . '.',
                'keywords' => [strtolower($parentCategory['name']), 'shop', 'quality', 'security'],
                'display_mode' => 'both',
                'products_per_page' => 24,
            ]);

            // Create subcategories
            foreach ($parentCategory['subcategories'] as $index => $subcategoryName) {
                // Create a unique slug by combining parent slug and subcategory name
                $subcategorySlug = $parentSlug . '-' . Str::slug($subcategoryName);

                // Get custom description for security doors
                $description = $parentCategory['descriptions'][$subcategoryName];

                ProductCategory::create([
                    'parent_id' => $parent->id,
                    'name' => $subcategoryName,
                    'slug' => $subcategorySlug,
                    'description' => $description,
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => $index,
                    'meta_title' => $subcategoryName . ' - Security Doors',
                    'meta_description' => 'Shop for ' . $subcategoryName . ' security doors from our premium collection.',
                    'keywords' => [strtolower($subcategoryName), 'security doors', 'entrance', 'premium'],
                    'display_mode' => 'products',
                    'products_per_page' => 24,
                ]);
            }
        }

        $this->command->info('Security door categories and subcategories seeded successfully!');
    }
}
