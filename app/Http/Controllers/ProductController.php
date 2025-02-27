<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

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
                $query->orderBy('sort_order');
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

    // app/Http/Controllers/ProductController.php
    public function show($slug)
    {
        $product = Product::with(['features', 'category', 'specifications', 'relatedProducts'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.products.show', compact('product'));
    }
}
