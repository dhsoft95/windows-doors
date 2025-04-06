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
            'New Arrival', 'On Sale', 'Bestseller', 'Premium', 'Security',
            'Limited Edition', 'Handmade', 'Custom', 'High-End', 'Reinforced'
        ];

        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[] = Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        // Security Door products by category
        $securityDoorProducts = [
            'Hi-Tech 8000' => [
                [
                    'name' => 'Hi-Tech 8000 Steel Core Security Door',
                    'short_description' => 'Premium security door with robust steel core and customizable exterior finish.',
                    'description' => 'Our flagship Hi-Tech 8000 Steel Core Security Door offers exceptional security, durability, and aesthetic appeal. Constructed with a robust steel core, these doors provide unmatched strength while allowing you to customize the exterior finish to suit your style. Choose from a range of premium materials, including glass, concrete, aluminum, wood-look, oven-painted steel, and more. The advanced security system features four massive bolts for superior protection against forced entry. Enhanced insulation panels ensure better thermal and sound insulation, creating a comfortable and energy-efficient environment. Our sophisticated design combines strength with elegance, complementing both modern and classic architectural styles.',
                    'price' => 1899.99,
                    'sale_price' => null,
                    'features' => [
                        ['Security Features: Steel Core Construction, Four Massive Bolts, Advanced Locking Mechanism, Reinforced Frame'],
                        ['Design Options: Glass Finish, Concrete Finish, Aluminum Finish, Wood-Look Finish, Oven-Painted Steel'],
                        ['Performance: Enhanced Thermal Insulation, Sound Insulation, Weather Resistant, Energy Efficient']
                    ],
                    'image' => 'products/security-doors/hi-tech-8000-1.jpeg',
                    'tags' => ['Premium', 'Security', 'High-End']
                ],
                [
                    'name' => 'Hi-Tech 8000 Glass Panel Security Door',
                    'short_description' => 'Modern security door featuring reinforced glass panels with steel core construction.',
                    'description' => 'The Hi-Tech 8000 Glass Panel Security Door combines extraordinary security with modern aesthetics. This premium door features reinforced glass panels that allow natural light while maintaining the robust steel core construction that the Hi-Tech series is known for. The door includes our signature four-bolt locking system and enhanced insulation properties. Perfect for contemporary homes seeking both protection and style.',
                    'price' => 2199.99,
                    'sale_price' => 1999.99,
                    'features' => [
                        ['Security Features: Steel Core Construction, Four Massive Bolts, Reinforced Glass Panels, Tamper-Resistant Frame'],
                        ['Design Options: Clear Glass, Frosted Glass, Tinted Glass, Pattern Options, Custom Sizing'],
                        ['Performance: UV Protection, Sound Insulation, Thermal Regulation, Easy Maintenance']
                    ],
                    'image' => 'products/security-doors/hi-tech-8000-2.jpeg',
                    'tags' => ['New Arrival', 'Premium', 'Security']
                ],
            ],
            'Model SUPREME 7000' => [
                [
                    'name' => 'SUPREME 7000 Mediterranean Security Door',
                    'short_description' => 'Mediterranean-inspired security door with aluminum decorative elements and exceptional safety standards.',
                    'description' => 'The SUPREME 7000 Mediterranean Security Door brings together authentic Mediterranean design with industry-leading security. This exceptional door features hand-crafted aluminum decorative elements and a unique, authentic appearance that adds character to any entrance. Conforming to five quality standards, the SUPREME 7000 offers an exceptionally high level of safety without compromising on aesthetics. Available with prestigious electrostatic painted finishes in a wide range of granular epoxy paint shades, this door can be customized to complement any architectural style. The door includes barred windows that enhance both security and visual appeal.',
                    'price' => 1799.99,
                    'sale_price' => null,
                    'features' => [
                        ['Security Standards: Five Quality Standards Certification, Reinforced Structure, Advanced Locking System, Anti-Tampering Frame'],
                        ['Design Elements: Aluminum Decorative Elements, Barred Windows, Mediterranean-Inspired Design, Electrostatic Paint Finish'],
                        ['Customization: Multiple Granular Epoxy Paint Options, Custom Size Available, Hardware Finish Options, Glass Options']
                    ],
                    'image' => 'products/security-doors/supreme-7000-1.jpeg',
                    'tags' => ['Handmade', 'Premium', 'Security']
                ],
                [
                    'name' => 'SUPREME 7000 Classic Barred Window Door',
                    'short_description' => 'Traditional security door with elegant barred windows and superior protection features.',
                    'description' => 'The SUPREME 7000 Classic Barred Window Door combines traditional elegance with modern security technology. This distinguished security door features meticulously crafted barred windows and aluminum decorative elements that hark back to Mediterranean architectural traditions. Built to conform to five strict quality standards, this door provides exceptional protection for your home or business. The prestigious electrostatic painted finish is available in multiple granular epoxy paint shades, allowing for personalization to match your exterior design scheme. Each door is individually crafted to ensure both beauty and uncompromising security.',
                    'price' => 1899.99,
                    'sale_price' => 1749.99,
                    'features' => [
                        ['Security Features: Five-Point Locking System, Reinforced Frame, Steel Core Construction, Anti-Drill Protection'],
                        ['Aesthetics: Classic Barred Windows, Decorative Aluminum Elements, Mediterranean Design Motifs, Premium Paint Finish'],
                        ['Installation: Professional Installation Included, Custom Fitting, Weather Sealing, Insulation Enhancement']
                    ],
                    'image' => 'products/security-doors/supreme-7000-2.jpeg',
                    'tags' => ['Bestseller', 'Security', 'On Sale']
                ],
            ],
            'ART 5000' => [
                [
                    'name' => 'ART 5000 European Castle-Inspired Security Door',
                    'short_description' => 'Artistic security door featuring handcrafted blacksmith-designed elements with an authentic aged appearance.',
                    'description' => 'The ART 5000 European Castle-Inspired Security Door is a masterpiece of craftsmanship and security. For those who admire the grandeur of ancient European castles, this door offers the perfect blend of security, artistry, and heritage. Each door in the ART 5000 series features unique handcrafted blacksmith-designed elements, adding an unparalleled touch of elegance and strength. The special coloring technique creates an authentic aged appearance that enhances its historic charm while concealing its modern security features. Beyond aesthetics, these doors offer superior security, durability, and craftsmanship, making them an exceptional choice for homes, villas, and commercial spaces that seek both beauty and protection.',
                    'price' => 2499.99,
                    'sale_price' => null,
                    'features' => [
                        ['Craftsmanship: Handcrafted Blacksmith Elements, Authentic Aged Appearance, Unique Artistic Design, Historic European Influence'],
                        ['Security Features: Reinforced Structure, Multi-Point Locking System, Tamper-Resistant Hardware, Concealed Security Elements'],
                        ['Materials: Premium Steel Construction, Hand-Forged Elements, Special Coloring Technique, Weather-Resistant Finish']
                    ],
                    'image' => 'products/security-doors/art-5000-1.png',
                    'tags' => ['Limited Edition', 'Handmade', 'Premium']
                ],
                [
                    'name' => 'ART 5000 Vintage Mansion Security Door',
                    'short_description' => 'Luxurious vintage-style security door with handcrafted elements and special aged coloring technique.',
                    'description' => 'The ART 5000 Vintage Mansion Security Door transforms your entrance into a statement of elegance and security. This extraordinary door draws inspiration from historic European mansions and castles, featuring exquisite handcrafted blacksmith-designed elements that showcase traditional artisanship. Each door undergoes a special coloring process to achieve an authentic aged appearance that tells a story of heritage and timeless beauty. Despite its classic appearance, the ART 5000 integrates modern security technology to provide exceptional protection. The combination of artistic excellence and robust security makes this door perfect for luxury homes, historic properties, and upscale commercial spaces seeking to make a bold architectural statement.',
                    'price' => 2799.99,
                    'sale_price' => 2599.99,
                    'features' => [
                        ['Artistic Elements: Hand-Forged Decorative Components, Vintage-Inspired Design, Unique to Each Door, Artistic Metalwork'],
                        ['Security: Reinforced Structure, Advanced Lock System, Concealed Hinges, Anti-Drill Plates'],
                        ['Finish: Authentic Aged Appearance, Special Coloring Technique, Weather-Resistant Coating, UV Protection']
                    ],
                    'image' => 'products/security-doors/art-5000-2.png',
                    'tags' => ['High-End', 'Handmade', 'Custom']
                ],
            ],
            'CHIC 3000' => [
                [
                    'name' => 'CHIC 3000 Contemporary Minimalist Security Door',
                    'short_description' => 'Sleek, minimalist security door with built-in nickel strips and superior thermal insulation.',
                    'description' => 'The CHIC 3000 Contemporary Minimalist Security Door is crafted for those who appreciate sophisticated aesthetics alongside superior security. This modern masterpiece features a clean, minimalist design that brings a refined and contemporary touch to any entrance. The door showcases elegant built-in nickel strips that create subtle geometric patterns, adding visual interest without overwhelming the senses. Beyond its stylish appearance, the CHIC 3000 offers exceptional thermal and acoustic insulation, ensuring comfort, energy efficiency, and noise reduction. Each door combines premium materials with advanced security features to deliver the perfect balance of style, security, and functionality for the discerning modern homeowner.',
                    'price' => 1699.99,
                    'sale_price' => null,
                    'features' => [
                        ['Design Elements: Built-in Nickel Strips, Minimalist Aesthetic, Contemporary Styling, Clean Lines'],
                        ['Insulation: Superior Thermal Insulation, Acoustic Sound Dampening, Energy Efficient, Climate Control Support'],
                        ['Security Features: Advanced Locking System, Reinforced Structure, Tamper-Resistant Design, Concealed Hinges']
                    ],
                    'image' => 'products/security-doors/chic-3000-1.png',
                    'tags' => ['New Arrival', 'Premium', 'Security']
                ],
                [
                    'name' => 'CHIC 3000 Modern Linear Security Door',
                    'short_description' => 'Ultra-modern security door featuring attached nickel strips in a sophisticated linear pattern.',
                    'description' => 'The CHIC 3000 Modern Linear Security Door represents the pinnacle of contemporary entrance design combined with state-of-the-art security. This sophisticated door features attached nickel strips arranged in an elegant linear pattern that creates a striking visual effect while maintaining a clean, modern aesthetic. The minimalist design complements modern architecture and interior styling, making it perfect for contemporary homes and commercial spaces. The door excels in both thermal and acoustic insulation, contributing to energy efficiency and creating a peaceful interior environment. Despite its sleek appearance, the CHIC 3000 incorporates robust security features that provide peace of mind without compromising on style.',
                    'price' => 1899.99,
                    'sale_price' => 1799.99,
                    'features' => [
                        ['Modern Design: Linear Nickel Strip Pattern, Contemporary Aesthetics, Geometric Elements, Sleek Hardware'],
                        ['Performance: Exceptional Thermal Insulation, Superior Sound Dampening, Weather Resistance, Low Maintenance'],
                        ['Construction: Reinforced Frame, Multi-Point Locking System, Premium Materials, Professional Installation Required']
                    ],
                    'image' => 'products/security-doors/chic-3000-2.png',
                    'tags' => ['Bestseller', 'High-End', 'On Sale']
                ],
            ]
        ];

        // Get security door categories
        $securityParentCategory = ProductCategory::where('name', 'ENTRANCE SECURITY DOORS')->first();

        if (!$securityParentCategory) {
            $this->command->error('ENTRANCE SECURITY DOORS category not found. Please run the ProductCategorySeeder first.');
            return;
        }

        $securityCategories = ProductCategory::where('parent_id', $securityParentCategory->id)->get();

        foreach ($securityCategories as $category) {
            $categoryName = $category->name;

            if (isset($securityDoorProducts[$categoryName])) {
                foreach ($securityDoorProducts[$categoryName] as $productData) {
                    // Create the product
                    $product = Product::create([
                        'product_category_id' => $category->id,
                        'name' => $productData['name'],
                        'slug' => Str::slug($productData['name']),
                        'short_description' => $productData['short_description'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'sale_price' => $productData['sale_price'],
                        'sku' => strtoupper(substr(Str::slug($categoryName), 0, 3)) . '-' . strtoupper($faker->bothify('???###')),
                        'stock_quantity' => rand(5, 30),
                        'is_in_stock' => true,
                        'is_featured' => true,
                        'is_active' => true,
                        'is_taxable' => true,
                        'is_door' => true,
                        'sort_order' => 10,
                        'main_image' => $productData['image'],
                        'meta_title' => $productData['name'],
                        'meta_description' => $productData['short_description'],
                        'keywords' => explode(' ', strtolower(str_replace('-', ' ', $productData['name']))),
                        'published_at' => now()->subDays(rand(0, 30)),
                    ]);

                    // Add features - using the correct structure based on your database schema
                    foreach ($productData['features'] as $index => $featureText) {
                        // Extract feature items as a simple array
                        $featureParts = explode(':', $featureText[0], 2);
                        $featureItems = [];

                        if (isset($featureParts[1])) {
                            $featureItemsString = trim($featureParts[1]);
                            $featureItems = array_map('trim', explode(',', $featureItemsString));
                        }

                        $product->features()->create([
                            'features' => $featureItems,
                            'sort_order' => $index + 1,
                        ]);
                    }

                    // Add tags
                    $productTags = [];
                    foreach ($productData['tags'] as $tagName) {
                        $tag = $tagModels[array_search($tagName, $tags)];
                        $productTags[] = $tag->id;
                    }
                    $product->tags()->sync($productTags);
                }
            }
        }

        // Add related products within same category
        $allProducts = Product::all();
        foreach ($allProducts as $product) {
            // Get category products excluding self
            $categoryProducts = $allProducts->where('product_category_id', $product->product_category_id)
                ->where('id', '!=', $product->id);

            if ($categoryProducts->count() > 0) {
                // Add all products from same category as related
                $product->relatedProducts()->sync($categoryProducts->pluck('id')->toArray());
            }
        }

        $this->command->info('Security door products seeded successfully: ' . $allProducts->count() . ' products created.');
    }
}
