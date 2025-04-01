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

        // Check if this is a parent category (no parent_id)
        $isParentCategory = $category->parent_id === null;
        $subcategories = collect();

        if ($isParentCategory) {
            // Get subcategories if this is a parent category
            $subcategories = ProductCategory::where('parent_id', $category->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        }

        // Query builder for products
        $query = Product::query()
            ->where('is_active', true);

        if ($isParentCategory) {
            // For parent categories, get products from all subcategories
            $subcategoryIds = $subcategories->pluck('id')->toArray();
            $query->whereIn('product_category_id', $subcategoryIds);

            // If no subcategories or also want to include direct products
            if (empty($subcategoryIds) || $category->display_mode !== 'subcategories') {
                $query->orWhere('product_category_id', $category->id);
            }
        } else {
            // For subcategories, get only products directly in this category
            $query->where('product_category_id', $category->id);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('sort_order')->orderBy('created_at', 'desc');
        }

        // Pagination
        $products = $query->paginate($category->products_per_page ?? 12);

        // Get parent categories for the sidebar navigation
        $parentCategories = ProductCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // If viewing a subcategory, get sibling categories (other subcategories of the same parent)
        $siblingCategories = collect();
        if (!$isParentCategory && $category->parent) {
            $siblingCategories = ProductCategory::where('parent_id', $category->parent_id)
                ->where('is_active', true)
                ->where('id', '!=', $category->id)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        }

        return view('pages.categories.show', [
            'category' => $category,
            'products' => $products,
            'parentCategories' => $parentCategories,
            'isParentCategory' => $isParentCategory,
            'subcategories' => $subcategories,
            'siblingCategories' => $siblingCategories
        ]);
    }

    /**
     * Display all product categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all parent categories
        $categories = ProductCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->where('is_active', true);
            }])
            ->withCount('subcategories') // Count subcategories
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('pages.categories.index', compact('categories'));
    }
}
