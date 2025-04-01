<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'is_featured',
        'sort_order',
        'meta_title',
        'meta_description',
        'keywords',
        'display_mode',
        'products_per_page',
        'parent_id',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'keywords' => 'array',
    ];

    /**
     * Get the products in this category
     */
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    /**
     * Get the parent category of this category (if it's a subcategory)
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Get the subcategories of this category
     */
    public function subcategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    /**
     * Check if this category has subcategories
     */
    public function hasSubcategories(): bool
    {
        return $this->subcategories()->count() > 0;
    }

    /**
     * Check if this category is a subcategory
     */
    public function isSubcategory(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Get the root categories (categories that are not subcategories)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get all products from this category and its subcategories
     */
    public function getAllProducts()
    {
        // Get direct products
        $productIds = $this->products()->pluck('id')->toArray();

        // Get products from subcategories
        foreach ($this->subcategories as $subcategory) {
            $productIds = array_merge($productIds, $subcategory->getAllProducts()->pluck('id')->toArray());
        }

        return Product::whereIn('id', $productIds);
    }
}
