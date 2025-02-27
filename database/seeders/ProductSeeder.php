<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductFeature;
use App\Models\ProductSpecification;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create common tags
        $tags = [
            ['name' => 'Security', 'slug' => 'security'],
            ['name' => 'Premium', 'slug' => 'premium'],
            ['name' => 'Aluminum', 'slug' => 'aluminum'],
            ['name' => 'Wood', 'slug' => 'wood'],
            ['name' => 'Metal', 'slug' => 'metal'],
            ['name' => 'Interior', 'slug' => 'interior'],
            ['name' => 'Exterior', 'slug' => 'exterior'],
            ['name' => 'Safety Glass', 'slug' => 'safety-glass'],
            ['name' => 'Sliding', 'slug' => 'sliding'],
            ['name' => 'Casement', 'slug' => 'casement'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        // Get category IDs
        $securityDoorsId = ProductCategory::where('slug', 'security-doors')->first()->id;
        $interiorDoorsId = ProductCategory::where('slug', 'interior-doors')->first()->id;
        $aluminumSolutionsId = ProductCategory::where('slug', 'aluminum-solutions')->first()->id;

        // Security Doors
        $this->createSecurityDoors($securityDoorsId);

        // Interior Doors
        $this->createInteriorDoors($interiorDoorsId);

        // Aluminum Solutions
        $this->createAluminumSolutions($aluminumSolutionsId);
    }

    private function createSecurityDoors($categoryId): void
    {
        $securityDoors = [
            [
                'product_category_id' => $categoryId,
                'name' => 'Premium Security Door',
                'slug' => 'premium-security-door',
                'short_description' => 'High security door with artistic design elements.',
                'description' => 'Our Premium Security Door combines exceptional protection with elegant design to safeguard your home while enhancing its aesthetic appeal. Perfect for luxury homes and high-security requirements.',
                'price' => 1499.99,
                'sale_price' => 1299.99,
                'sku' => 'SD-PREM-001',
                'stock_quantity' => 10,
                'is_in_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'is_taxable' => true,
                'sort_order' => 1,
                'main_image' => 'products/security-door-main.jpg',
                'meta_title' => 'Premium Security Door | Simba Doors',
                'meta_description' => 'High-security door combining protection with elegant design. Perfect for homes and offices.',
                'keywords' => json_encode(['security door', 'premium door', 'safety door']),
                'published_at' => Carbon::now(),
                'features' => [
                    'Heavy-duty steel construction',
                    'Multi-point locking system',
                    'Weather-resistant coating',
                    'Sound insulation',
                    'Fire-resistant materials'
                ],
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Steel with reinforced frame'],
                    ['label' => 'Thickness', 'value' => '2.0mm'],
                    ['label' => 'Lock Type', 'value' => '5-point security system'],
                    ['label' => 'Finish', 'value' => 'Powder coated'],
                    ['label' => 'Warranty', 'value' => '10 years']
                ],
                'images' => [
                    ['image' => 'products/security-door-1.jpg', 'alt_text' => 'Front view'],
                    ['image' => 'products/security-door-2.jpg', 'alt_text' => 'Side view'],
                    ['image' => 'products/security-door-3.jpg', 'alt_text' => 'Lock detail']
                ],
                'tags' => ['Security', 'Premium', 'Metal']
            ],
            [
                'product_category_id' => $categoryId,
                'name' => 'Executive Security Door',
                'slug' => 'executive-security-door',
                'short_description' => 'Executive-grade security door with modern design.',
                'description' => 'The Executive Security Door offers premium protection with a sophisticated modern design. Ideal for offices and luxury residences.',
                'price' => 1899.99,
                'sale_price' => 1699.99,
                'sku' => 'SD-EXEC-001',
                'stock_quantity' => 8,
                'is_in_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'is_taxable' => true,
                'sort_order' => 2,
                'main_image' => 'products/executive-door-main.jpg',
                'meta_title' => 'Executive Security Door | Simba Doors',
                'meta_description' => 'Executive-grade security door with modern design features. Perfect for offices and luxury homes.',
                'keywords' => json_encode(['executive door', 'security door', 'modern door']),
                'published_at' => Carbon::now(),
                'features' => [
                    'Premium steel construction',
                    'Biometric lock option',
                    'Sound dampening core',
                    'Anti-drill protection',
                    'Contemporary design elements'
                ],
                'specifications' => [
                    ['label' => 'Material', 'value' => 'High-grade steel'],
                    ['label' => 'Thickness', 'value' => '2.5mm'],
                    ['label' => 'Lock Type', 'value' => 'Digital security system'],
                    ['label' => 'Finish', 'value' => 'Premium metallic'],
                    ['label' => 'Warranty', 'value' => '15 years']
                ],
                'images' => [
                    ['image' => 'products/executive-door-1.jpg', 'alt_text' => 'Front view'],
                    ['image' => 'products/executive-door-2.jpg', 'alt_text' => 'Lock system'],
                    ['image' => 'products/executive-door-3.jpg', 'alt_text' => 'Interior view']
                ],
                'tags' => ['Security', 'Premium', 'Metal']
            ]
        ];

        foreach ($securityDoors as $doorData) {
            $this->createProduct($doorData);
        }
    }

    private function createInteriorDoors($categoryId): void
    {
        $interiorDoors = [
            [
                'product_category_id' => $categoryId,
                'name' => 'Classic Wooden Interior Door',
                'slug' => 'classic-wooden-interior-door',
                'short_description' => 'Classic wooden door for elegant interiors.',
                'description' => 'Our Classic Wooden Interior Door combines timeless design with superior craftsmanship. Perfect for adding warmth and elegance to any room.',
                'price' => 699.99,
                'sale_price' => 599.99,
                'sku' => 'ID-WOOD-001',
                'stock_quantity' => 15,
                'is_in_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'is_taxable' => true,
                'sort_order' => 1,
                'main_image' => 'products/wooden-door-main.jpg',
                'meta_title' => 'Classic Wooden Interior Door | Simba Doors',
                'meta_description' => 'Classic wooden interior door with elegant design. Perfect for homes and hotels.',
                'keywords' => json_encode(['wooden door', 'interior door', 'classic door']),
                'published_at' => Carbon::now(),
                'features' => [
                    'Solid wood construction',
                    'Premium wood finish',
                    'Sound insulation',
                    'Moisture resistant',
                    'Easy maintenance'
                ],
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Solid hardwood'],
                    ['label' => 'Thickness', 'value' => '40mm'],
                    ['label' => 'Finish Options', 'value' => 'Natural, Oak, Mahogany'],
                    ['label' => 'Hardware', 'value' => 'Premium handles and hinges'],
                    ['label' => 'Warranty', 'value' => '5 years']
                ],
                'images' => [
                    ['image' => 'products/wooden-door-1.jpg', 'alt_text' => 'Front view'],
                    ['image' => 'products/wooden-door-2.jpg', 'alt_text' => 'Wood grain detail'],
                    ['image' => 'products/wooden-door-3.jpg', 'alt_text' => 'Handle detail']
                ],
                'tags' => ['Interior', 'Wood', 'Premium']
            ],
            [
                'product_category_id' => $categoryId,
                'name' => 'Modern Metal Interior Door',
                'slug' => 'modern-metal-interior-door',
                'short_description' => 'Contemporary metal door for modern interiors.',
                'description' => 'The Modern Metal Interior Door features clean lines and a sleek design, perfect for contemporary spaces and modern offices.',
                'price' => 899.99,
                'sale_price' => 799.99,
                'sku' => 'ID-MTL-001',
                'stock_quantity' => 12,
                'is_in_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'is_taxable' => true,
                'sort_order' => 2,
                'main_image' => 'products/metal-door-main.jpg',
                'meta_title' => 'Modern Metal Interior Door | Simba Doors',
                'meta_description' => 'Contemporary metal interior door with sleek design. Perfect for modern offices.',
                'keywords' => json_encode(['metal door', 'interior door', 'modern door']),
                'published_at' => Carbon::now(),
                'features' => [
                    'Lightweight metal construction',
                    'Modern minimalist design',
                    'Sound dampening core',
                    'Scratch-resistant finish',
                    'Contemporary hardware'
                ],
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Aluminum alloy'],
                    ['label' => 'Thickness', 'value' => '45mm'],
                    ['label' => 'Finish Options', 'value' => 'Silver, Black, Bronze'],
                    ['label' => 'Hardware', 'value' => 'Modern handle set'],
                    ['label' => 'Warranty', 'value' => '7 years']
                ],
                'images' => [
                    ['image' => 'products/metal-door-1.jpg', 'alt_text' => 'Front view'],
                    ['image' => 'products/metal-door-2.jpg', 'alt_text' => 'Handle detail'],
                    ['image' => 'products/metal-door-3.jpg', 'alt_text' => 'Finish detail']
                ],
                'tags' => ['Interior', 'Metal', 'Modern']
            ]
        ];

        foreach ($interiorDoors as $doorData) {
            $this->createProduct($doorData);
        }
    }

    private function createAluminumSolutions($categoryId): void
    {
        $aluminumProducts = [
            [
                'product_category_id' => $categoryId,
                'name' => 'Premium Sliding Window',
                'slug' => 'premium-sliding-window',
                'short_description' => 'Premium aluminum sliding window with safety glass.',
                'description' => 'Our Premium Sliding Window combines smooth operation with excellent insulation properties. Perfect for modern homes and offices.',
                'price' => 899.99,
                'sale_price' => 799.99,
                'sku' => 'AW-SLD-001',
                'stock_quantity' => 20,
                'is_in_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'is_taxable' => true,
                'sort_order' => 1,
                'main_image' => 'products/sliding-window-main.jpg',
                'meta_title' => 'Premium Sliding Window | Simba Doors',
                'meta_description' => 'Premium aluminum sliding window with safety glass. Energy efficient and stylish.',
                'keywords' => json_encode(['sliding window', 'aluminum window', 'safety glass']),
                'published_at' => Carbon::now(),
                'features' => [
                    'Smooth sliding mechanism',
                    'Double-glazed safety glass',
                    'Weather-proof seals',
                    'Energy efficient design',
                    'Easy cleaning access'
                ],
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Premium aluminum'],
                    ['label' => 'Glass', 'value' => '6mm tempered safety glass'],
                    ['label' => 'Track System', 'value' => 'Double track with rollers'],
                    ['label' => 'Finish Options', 'value' => 'Silver, Black, Bronze'],
                    ['label' => 'Warranty', 'value' => '10 years']
                ],
                'images' => [
                    ['image' => 'products/sliding-window-1.jpg', 'alt_text' => 'Front view'],
                    ['image' => 'products/sliding-window-2.jpg', 'alt_text' => 'Track detail'],
                    ['image' => 'products/sliding-window-3.jpg', 'alt_text' => 'Handle detail']
                ],
                'tags' => ['Aluminum', 'Sliding', 'Safety Glass']
            ],
            [
                'product_category_id' => $categoryId,
                'name' => 'Aluminum Casement Window',
                'slug' => 'aluminum-casement-window',
                'short_description' => 'Modern casement window with safety glass.',
                'description' => 'The Aluminum Casement Window offers maximum ventilation and unobstructed views. Perfect for residential and commercial applications.',
                'price' => 799.99,
                'sale_price' => 699.99,
                'sku' => 'AW-CSM-001',
                'stock_quantity' => 15,
                'is_in_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'is_taxable' => true,
                'sort_order' => 2,
                'main_image' => 'products/casement-window-main.jpg',
                'meta_title' => 'Aluminum Casement Window | Simba Doors',
                'meta_description' => 'Modern aluminum casement window with safety glass. Energy efficient and durable.',
                'keywords' => json_encode(['casement window', 'aluminum window', 'safety glass']),
                'published_at' => Carbon::now(),
                'features' => [
                    'Full opening design',
                    'Double-glazed safety glass',
                    'Multi-point locking system',
                    'Weather-resistant seals',
                    'Smooth operation mechanism'
                ],
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Premium aluminum'],
                    ['label' => 'Glass', 'value' => '6mm tempered safety glass'],
                    ['label' => 'Opening', 'value' => '90-degree casement'],
                    ['label' => 'Finish Options', 'value' => 'Silver, Black, White'],
                    ['label' => 'Warranty', 'value' => '10 years']
                ],
                'images' => [
                    ['image' => 'products/casement-window-1.jpg', 'alt_text' => 'Front view'],
                    ['image' => 'products/casement-window-2.jpg', 'alt_text' => 'Open position'],
                    ['image' => 'products/casement-window-3.jpg', 'alt_text' => 'Handle detail']
                ],
                'tags' => ['Aluminum', 'Casement', 'Safety Glass']
            ],
            [
                'product_category_id' => $categoryId,
                'name' => 'Aluminum Sliding Door',
                'slug' => 'aluminum-sliding-door',
                'short_description' => 'Modern sliding door for seamless access.',
                'description' => 'Our Aluminum Sliding Door provides smooth operation and excellent insulation. Perfect for patios and balconies.',
                'price' => 1299.99,
                'sale_price' => 1199.99,
                'sku' => 'AD-SLD-001',
                'stock_quantity' => 10,
                'is_in_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'is_taxable' => true,
                'sort_order' => 3,
                'main_image' => 'products/sliding-door-main.jpg',
                'meta_title' => 'Aluminum Sliding Door | Simba Doors',
                'meta_description' => 'Premium aluminum sliding door with safety glass. Perfect for modern homes.',
                'keywords' => json_encode(['sliding door', 'aluminum door', 'patio door']),
                'published_at' => Carbon::now(),
                'features' => [
                    'Smooth sliding mechanism',
                    'Heavy-duty track system',
                    'Double-glazed safety glass',
                    'Anti-lift system',
                    'Energy efficient design'
                ],
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Premium aluminum'],
                    ['label' => 'Glass', 'value' => '8mm tempered safety glass'],
                    ['label' => 'Track', 'value' => 'Double track system'],
                    ['label' => 'Finish Options', 'value' => 'Silver, Black, Bronze'],
                    ['label' => 'Warranty', 'value' => '10 years']
                ],
                'images' => [
                    ['image' => 'products/sliding-door-1.jpg', 'alt_text' => 'Front view'],
                    ['image' => 'products/sliding-door-2.jpg', 'alt_text' => 'Track detail'],
                    ['image' => 'products/sliding-door-3.jpg', 'alt_text' => 'Handle mechanism']
                ],
                'tags' => ['Aluminum', 'Sliding', 'Safety Glass']
            ]
        ];

        foreach ($aluminumProducts as $productData) {
            $this->createProduct($productData);
        }
    }

    private function createProduct(array $data): void
    {
        // Extract related data
        $features = $data['features'];
        $specifications = $data['specifications'];
        $images = $data['images'];
        $tagNames = $data['tags'];

        unset($data['features'], $data['specifications'], $data['images'], $data['tags']);

        // Create the product
        $product = Product::create($data);

        // Create features
        ProductFeature::create([
            'product_id' => $product->id,
            'features' => json_encode($features),
            'sort_order' => 1
        ]);

        // Create specifications
        foreach ($specifications as $index => $spec) {
            ProductSpecification::create([
                'product_id' => $product->id,
                'label' => $spec['label'],
                'value' => $spec['value'],
                'sort_order' => $index + 1
            ]);
        }

        // Create images
        foreach ($images as $index => $imageData) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imageData['image'],
                'alt_text' => $imageData['alt_text'],
                'sort_order' => $index + 1
            ]);
        }

        // Attach tags
        $tags = Tag::whereIn('name', $tagNames)->get();
        $product->tags()->attach($tags);

        // Set related products
        if (Product::count() > 1) {
            $relatedProducts = Product::where('id', '!=', $product->id)
                ->where('product_category_id', $product->product_category_id)
                ->inRandomOrder()
                ->limit(3)
                ->get();

            $product->relatedProducts()->attach($relatedProducts);
        }
    }
}
