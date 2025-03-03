<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class ProductPerformanceMatrix extends Widget
{
    protected static string $view = 'filament.admin.widgets.product-performance-matrix';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'matrix' => $this->generateProductMatrix(),
            'topProducts' => $this->getTopProducts(),
            'lowStockProducts' => $this->getLowStockProducts(),
        ];
    }

    private function generateProductMatrix(): array
    {
        // Get featured status distribution
        $featuredData = [
            'featured' => Product::where('is_featured', true)->count(),
            'not_featured' => Product::where('is_featured', false)->count(),
        ];

        // Get sale status distribution
        $saleData = DB::table('products')
            ->selectRaw('COUNT(CASE WHEN sale_price > 0 AND sale_price < price THEN 1 END) as on_sale')
            ->selectRaw('COUNT(CASE WHEN sale_price IS NULL OR sale_price = 0 OR sale_price >= price THEN 1 END) as regular_price')
            ->first();

        // Get stock status distribution
        $stockData = [
            'in_stock' => Product::where('is_in_stock', true)->count(),
            'out_of_stock' => Product::where('is_in_stock', false)->count(),
        ];

        // Get active status distribution
        $activeData = [
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
        ];

        // Get price range distribution
        $priceRanges = [
            '0-50' => Product::whereBetween('price', [0, 50])->count(),
            '51-100' => Product::whereBetween('price', [51, 100])->count(),
            '101-200' => Product::whereBetween('price', [101, 200])->count(),
            '201+' => Product::where('price', '>', 200)->count(),
        ];

        // Calculate discount range distribution
        $discountData = [
            'no_discount' => Product::whereNull('sale_price')->orWhere('sale_price', 0)->orWhereRaw('sale_price >= price')->count(),
            'small' => Product::whereRaw('sale_price > 0 AND sale_price < price AND (price - sale_price) / price <= 0.2')->count(),
            'medium' => Product::whereRaw('sale_price > 0 AND sale_price < price AND (price - sale_price) / price > 0.2 AND (price - sale_price) / price <= 0.5')->count(),
            'large' => Product::whereRaw('sale_price > 0 AND sale_price < price AND (price - sale_price) / price > 0.5')->count(),
        ];

        return [
            'featured' => $featuredData,
            'sale' => [
                'on_sale' => $saleData->on_sale ?? 0,
                'regular_price' => $saleData->regular_price ?? 0,
            ],
            'stock' => $stockData,
            'active' => $activeData,
            'price_ranges' => $priceRanges,
            'discount_ranges' => $discountData,
        ];
    }

    private function getTopProducts(): array
    {
        // In a real application, you might use order data to determine top products
        // For demo purposes, we'll just get featured products with stock
        return Product::where('is_featured', true)
            ->where('is_in_stock', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'current_price' => $product->current_price,
                    'discount' => $product->discount_percentage,
                    'in_stock' => $product->is_in_stock,
                ];
            })
            ->toArray();
    }

    private function getLowStockProducts(): array
    {
        // Get products with low stock (less than 10 items)
        return Product::where('is_in_stock', true)
            ->where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock' => $product->stock_quantity,
                    'current_price' => $product->current_price,
                ];
            })
            ->toArray();
    }
}
