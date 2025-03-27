<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFeature;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true );

        // Category Filter
        if ($request->has('category')) {
            $query->where('product_category_id', $request->category);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $products = $query->with('category')->paginate(9);

        // Get categories for filter dropdown
        $categories = ProductCategory::where('is_active', true)->get();

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['features', 'category', 'specifications', 'relatedProducts'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Format features data for easier access in the blade template
        $formattedFeatures = [];
        if ($product->features && $product->features->count() > 0) {
            foreach ($product->features as $featureRecord) {
                if (is_array($featureRecord->features)) {
                    $formattedFeatures = array_merge($formattedFeatures, $featureRecord->features);
                }
            }
        }

        // Pass both the product and the formatted features to the view
        return view('pages.products.show', [
            'product' => $product,
            'productFeatures' => $formattedFeatures
        ]);
    }

    public function featured()
    {
        // Get all featured products
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        // Pass the products to the existing gallery blade file
        return view('layouts.partials.gallery', [
            'products' => $featuredProducts
        ]);
    }
}
