<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create product_categories table
        if (!Schema::hasTable('product_categories')) {
            Schema::create('product_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_featured')->default(false);
                $table->integer('sort_order')->default(0);
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->json('keywords')->nullable();
                $table->string('display_mode')->default('products');
                $table->integer('products_per_page')->default(24);
                $table->timestamps();
            });
        }

        // 2. Create products table
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_category_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('short_description')->nullable();
                $table->longText('description');
                $table->decimal('price', 10, 2)->nullable();
                $table->decimal('sale_price', 10, 2)->nullable();
                $table->string('sku')->unique()->nullable();
                $table->integer('stock_quantity')->default(0);
                $table->boolean('is_in_stock')->default(true);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_active')->default(true);
                $table->boolean('is_taxable')->default(true);
                $table->integer('sort_order')->default(0);
                $table->string('main_image')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->json('keywords')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            // If products table exists, add the new columns
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'price')) {
                    $table->decimal('price', 10, 2)->default(0);
                }
                if (!Schema::hasColumn('products', 'sale_price')) {
                    $table->decimal('sale_price', 10, 2)->nullable();
                }
                if (!Schema::hasColumn('products', 'sku')) {
                    $table->string('sku')->nullable()->unique();
                }
                if (!Schema::hasColumn('products', 'stock_quantity')) {
                    $table->integer('stock_quantity')->default(0);
                }
                if (!Schema::hasColumn('products', 'is_in_stock')) {
                    $table->boolean('is_in_stock')->default(true);
                }
                if (!Schema::hasColumn('products', 'is_taxable')) {
                    $table->boolean('is_taxable')->default(true);
                }
                if (!Schema::hasColumn('products', 'published_at')) {
                    $table->timestamp('published_at')->nullable();
                }
                if (!Schema::hasColumn('products', 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (!Schema::hasColumn('products', 'meta_description')) {
                    $table->text('meta_description')->nullable();
                }
                if (!Schema::hasColumn('products', 'keywords')) {
                    $table->json('keywords')->nullable();
                }
                if (!Schema::hasColumn('products', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }

        // 3. Create product_images table
        if (!Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('image');
                $table->string('alt_text')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // 4. Create product_features table
        if (!Schema::hasTable('product_features')) {
            Schema::create('product_features', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->json('features')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // 5. Create product_specifications table
        if (!Schema::hasTable('product_specifications')) {
            Schema::create('product_specifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('label');
                $table->string('value');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }


        // 6. Create tags table
        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // 7. Create product_tag pivot table
        if (!Schema::hasTable('product_tag')) {
            Schema::create('product_tag', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('tag_id')->constrained()->onDelete('cascade');
                $table->timestamps();

                $table->unique(['product_id', 'tag_id']);
            });
        }

        // 8. Create product_related_products pivot table
        if (!Schema::hasTable('product_related_products')) {
            Schema::create('product_related_products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('related_product_id')->constrained('products')->onDelete('cascade');
                $table->timestamps();

                $table->unique(['product_id', 'related_product_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key constraints
        Schema::dropIfExists('product_related_products');
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_features');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('tags');

        // Remove added columns from existing products table
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $columns = [
                    'price', 'sale_price', 'sku', 'stock_quantity', 'is_in_stock',
                    'is_taxable', 'published_at', 'meta_title', 'meta_description',
                    'keywords', 'deleted_at'
                ];

                foreach ($columns as $column) {
                    if (Schema::hasColumn('products', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        } else {
            Schema::dropIfExists('products');
        }

        Schema::dropIfExists('product_categories');
    }
};
