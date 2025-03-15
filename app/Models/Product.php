<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'is_in_stock',
        'is_featured',
        'is_active',
        'is_taxable',
        'sort_order',
        'main_image',
        'meta_title',
        'meta_description',
        'keywords',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_in_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_taxable' => 'boolean',
        'keywords' => 'array',
        'published_at' => 'datetime',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function specifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order');
    }

    public function features(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductFeature::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function relatedProducts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_related_products',
            'product_id',
            'related_product_id'
        );
    }

    // Calculate if the product is on sale
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->price;
    }

    // Get the current price (sale price if on sale, regular price if not)
    public function getCurrentPriceAttribute()
    {
        return $this->is_on_sale ? $this->sale_price : $this->price;
    }

    // Calculate discount percentage
    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) {
            return 0;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }
}
