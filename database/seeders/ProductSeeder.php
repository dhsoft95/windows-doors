<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFeature;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Properly clear existing data with foreign key checks disabled
        Schema::disableForeignKeyConstraints();

        // Clear data from all related tables
        DB::table('product_features')->truncate();
        DB::table('product_tag')->truncate(); // Pivot table for product-tag relationship
        DB::table('product_related_products')->truncate(); // Pivot table for related products
        DB::table('products')->truncate();
        DB::table('tags')->truncate();

        Schema::enableForeignKeyConstraints();

        $faker = Faker::create();

        // Create tags
        $tags = [
            'New Arrival', 'On Sale', 'Bestseller', 'Eco-Friendly', 'Premium',
            'Limited Edition', 'Handmade', 'Imported', 'Organic', 'Sustainable'
        ];

        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[] = Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        // Get subcategories
        $subcategories = ProductCategory::whereNotNull('parent_id')->get();

        // Create example products for each subcategory
        foreach ($subcategories as $subcategory) {
            $parent = ProductCategory::find($subcategory->parent_id);
            $isDoorsCategory = $parent && Str::contains($parent->name, 'Doors');

            // Create 5-10 products per subcategory
            $numProducts = rand(5, 10);

            for ($i = 0; $i < $numProducts; $i++) {
                $productName = $faker->words(rand(2, 4), true);

                // Add category name for better context
                if (rand(0, 1)) {
                    $productName .= ' ' . Str::singular($subcategory->name);
                }

                $productName = ucwords($productName);

                $price = $faker->randomFloat(2, 10, 1000);
                $salePrice = rand(0, 3) === 0 ? $price * (rand(70, 95) / 100) : null; // 25% chance of being on sale

                $product = Product::create([
                    'product_category_id' => $subcategory->id,
                    'name' => $productName,
                    'slug' => Str::slug($productName),
                    'short_description' => $faker->sentence(rand(10, 20)),
                    'description' => $faker->paragraphs(rand(3, 6), true),
                    'price' => $price,
                    'sale_price' => $salePrice,
                    'sku' => strtoupper(substr(Str::slug($subcategory->name), 0, 3)) . '-' . strtoupper($faker->bothify('???###')),
                    'stock_quantity' => rand(0, 100),
                    'is_in_stock' => rand(0, 10) > 1, // 90% chance of being in stock
                    'is_featured' => rand(0, 5) === 0, // 20% chance of being featured
                    'is_active' => rand(0, 10) > 1, // 90% chance of being active
                    'is_taxable' => true,
                    'is_door' => $isDoorsCategory,
                    'sort_order' => rand(0, 100),
                    'main_image' => null, // We would need actual image files for this
                    'meta_title' => $productName,
                    'meta_description' => $faker->sentence(rand(10, 15)),
                    'keywords' => $faker->words(rand(3, 6)),
                    'published_at' => now()->subDays(rand(0, 30)),
                ]);

                // Add features (1-4 feature groups)
                $numFeatureGroups = rand(1, 4);
                for ($j = 0; $j < $numFeatureGroups; $j++) {
                    $product->features()->create([
                        'features' => $faker->words(rand(3, 6)),
                        'sort_order' => $j + 1,
                    ]);
                }

                // Add tags (0-4 random tags)
                $numTags = rand(0, 4);
                if ($numTags > 0) {
                    $selectedTags = $tagModels;
                    shuffle($selectedTags);
                    $selectedTags = array_slice($selectedTags, 0, $numTags);

                    $tagIds = collect($selectedTags)->pluck('id')->toArray();
                    $product->tags()->sync($tagIds);
                }
            }
        }

        // Add related products randomly
        $allProducts = Product::all();
        foreach ($allProducts as $product) {
            // Get 0-4 random related products (excluding self)
            $relatedProductCount = rand(0, 4);
            if ($relatedProductCount > 0 && $allProducts->count() > 1) {
                $potentialRelatedProducts = $allProducts->where('id', '!=', $product->id)->random(min($relatedProductCount, $allProducts->count() - 1));
                $product->relatedProducts()->sync($potentialRelatedProducts->pluck('id')->toArray());
            }
        }

        $this->command->info('Products seeded successfully: ' . $allProducts->count() . ' products created.');
    }
}
