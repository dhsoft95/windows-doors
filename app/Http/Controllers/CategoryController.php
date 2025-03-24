<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display products for a specific category.
     *
     * @param  string  $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show($slug, Request $request)
    {
        // Find the category by slug
        $category = ProductCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get products that belong to this category
        $query = Product::query()
            ->where('is_active', true)
            ->where('product_category_id', $category->id);

        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Fetch from new to old
        }

        // Pagination
        $products = $query->paginate(9);

        // Get all categories for the filter dropdown
        $categories = ProductCategory::where('is_active', true)->get();

        return view('pages.categories.show', [
            'category' => $category,
            'products' => $products,
            'categories' => $categories
        ]);
    }


    /**
     * Display all product categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = ProductCategory::where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->get();

        return view('pages.categories.index', compact('categories'));
    }
}
