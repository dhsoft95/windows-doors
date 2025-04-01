@extends('layouts.app')

@section('content')
    <div class="category-page py-4 py-lg-5">
        <div class="container">
            <!-- Breadcrumbs Navigation -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                    @if(!$isParentCategory && $category->parent)
                        <li class="breadcrumb-item"><a href="{{ route('categories.show', $category->parent->slug) }}">{{ $category->parent->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="row g-4">
                <!-- Sidebar Filter Panel -->
                <div class="col-lg-3 order-2 order-lg-1">
                    <div class="sidebar-container">
                        <!-- Category Image with Text Overlay -->
                        <div class="category-featured-image mb-4">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/placeholder.jpg') }}"
                                 alt="{{ $category->name }}"
                                 class="img-fluid rounded">
                            <div class="category-overlay">
                                <h1 class="category-title">{{ $category->name }}</h1>
                            </div>
                        </div>

                        <!-- Filter Toggle for Mobile -->
                        <button class="btn btn-outline-primary w-100 d-lg-none mb-3"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#sidebarFilters"
                                aria-expanded="false"
                                aria-controls="sidebarFilters">
                            <i class="fa-solid fa-sliders me-2"></i> Browse & Filter
                        </button>

                        <div class="collapse d-lg-block" id="sidebarFilters">
                            <!-- Browse Parent Categories -->
                            <div class="sidebar-card mb-4">
                                <div class="sidebar-card-header">
                                    <h2 class="sidebar-title">
                                        <i class="fa-solid fa-folder-open text-primary me-2"></i>
                                        Categories
                                    </h2>
                                </div>
                                <div class="sidebar-card-body">
                                    <ul class="category-nav">
                                        @foreach($parentCategories as $parentCat)
                                            <li class="{{ ($isParentCategory && $parentCat->id == $category->id) || (!$isParentCategory && $category->parent_id == $parentCat->id) ? 'active parent-category' : 'parent-category' }}">
                                                <a href="{{ route('categories.show', $parentCat->slug) }}"
                                                   class="d-flex justify-content-between align-items-center parent-link"
                                                   data-has-children="{{ $parentCat->subcategories_count > 0 ? 'true' : 'false' }}">
                                                    <span>{{ $parentCat->name }}</span>
                                                    @if($parentCat->subcategories_count > 0)
                                                        <i class="fas {{ ($isParentCategory && $parentCat->id == $category->id) || (!$isParentCategory && $category->parent_id == $parentCat->id) ? 'fa-chevron-down' : 'fa-chevron-right' }}"></i>
                                                    @endif
                                                </a>

                                                <!-- Subcategories for this parent -->
                                                @if(($isParentCategory && $parentCat->id == $category->id) || (!$isParentCategory && $category->parent_id == $parentCat->id))
                                                    <ul class="subcategory-nav">
                                                        @if($isParentCategory && $parentCat->id == $category->id)
                                                            @foreach($subcategories as $subCat)
                                                                <li>
                                                                    <a href="{{ route('categories.show', $subCat->slug) }}" class="subcategory-link">
                                                                        <i class="fas fa-angle-right me-2"></i> {{ $subCat->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        @elseif(!$isParentCategory && $category->parent_id == $parentCat->id)
                                                            <li class="active">
                                                                <a href="{{ route('categories.show', $category->slug) }}" class="subcategory-link">
                                                                    <i class="fas fa-angle-right me-2"></i> {{ $category->name }}
                                                                </a>
                                                            </li>
                                                            @foreach($siblingCategories as $siblingCat)
                                                                <li>
                                                                    <a href="{{ route('categories.show', $siblingCat->slug) }}" class="subcategory-link">
                                                                        <i class="fas fa-angle-right me-2"></i> {{ $siblingCat->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Sort Options -->
                            <div class="sidebar-card mb-4">
                                <div class="sidebar-card-header">
                                    <h2 class="sidebar-title">
                                        <i class="fa-solid fa-sort text-primary me-2"></i>
                                        Sort By
                                    </h2>
                                </div>
                                <div class="sidebar-card-body">
                                    <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="sort-form">
                                        <div class="form-group">
                                            <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                                                <option value="">Default</option>
                                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                                    Price: Low to High
                                                </option>
                                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                                    Price: High to Low
                                                </option>
                                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                                    Newest First
                                                </option>
                                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                                    Name: A to Z
                                                </option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Active Filters -->
                            @if(request()->anyFilled(['sort', 'price_min', 'price_max', 'in_stock']))
                                <div class="sidebar-card mb-4">
                                    <div class="sidebar-card-header">
                                        <h2 class="sidebar-title">
                                            <i class="fa-solid fa-filter text-primary me-2"></i>
                                            Active Filters
                                        </h2>
                                    </div>
                                    <div class="sidebar-card-body">
                                        <div class="active-filters">
                                            @if(request()->filled('sort'))
                                                <div class="filter-tag">
                                                    Sort: {{ ucfirst(str_replace(['_asc', '_desc'], [': Low to High', ': High to Low'], request('sort'))) }}
                                                    <a href="{{ route('categories.show', $category->slug, array_merge(request()->except('sort'), ['page' => 1])) }}" class="filter-remove" aria-label="Remove sort filter">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="text-center mt-3">
                                                <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-sm btn-outline-secondary">
                                                    Clear All Filters
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Products Content -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <!-- Header with Category Info -->
                    <div class="category-header mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="category-name mb-2">{{ $category->name }}</h1>
                                <div class="category-description">
                                    {!! $category->description !!}
                                </div>
                            </div>

                            <!-- Products Count and View Toggle -->
                            <div class="col-md-4">
                                <div class="products-toolbar d-flex justify-content-md-end align-items-center mt-3 mt-md-0">
                                    <div class="products-count me-3">
                                        Showing <span class="fw-medium">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> of <span class="fw-medium">{{ $products->total() }}</span> products
                                    </div>
                                    <div class="view-switcher">
                                        <div class="btn-group" role="group" aria-label="View options">
                                            <button type="button" class="btn btn-sm btn-outline-secondary active" id="grid-view" aria-label="Grid view">
                                                <i class="fas fa-th-large"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="list-view" aria-label="List view">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subcategories Display (for parent categories) -->
                    @if($isParentCategory && $subcategories->count() > 0)
                        <div class="subcategories-grid mb-5">
                            <h2 class="section-title mb-4">Browse {{ $category->name }} By Category</h2>
                            <div class="row g-4">
                                @foreach($subcategories as $subCat)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <a href="{{ route('categories.show', $subCat->slug) }}" class="subcategory-card">
                                            <div class="subcategory-image">
                                                @if($subCat->image)
                                                    <img src="{{ asset('storage/' . $subCat->image) }}" alt="{{ $subCat->name }}">
                                                @else
                                                    <div class="subcategory-icon">
                                                        <i class="fas fa-folder"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="subcategory-name">{{ $subCat->name }}</div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Products Grid -->
                    <div class="products-grid" id="products-container">
                        @if($products->count() > 0)
                            <div class="row g-4">
                                @foreach($products as $product)
                                    <div class="col-md-6 col-lg-4 product-item">
                                        <div class="product-card h-100" data-product-id="{{ $product->id }}">
                                            <!-- Product Image & Quick Actions -->
                                            <div class="product-image-container">
                                                <a href="{{ route('products.show', $product->slug) }}" class="product-image-link">
                                                    @if($product->main_image)
                                                        <img src="{{ asset('storage/' . $product->main_image) }}"
                                                             alt="{{ $product->name }}"
                                                             class="product-image">
                                                    @else
                                                        <img src="{{ asset('images/placeholder.jpg') }}"
                                                             alt="{{ $product->name }}"
                                                             class="product-image">
                                                    @endif
                                                </a>

                                                <!-- Quick Actions -->
                                                <div class="product-actions">
                                                    <button type="button" class="btn-action btn-wishlist" aria-label="Add to wishlist">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                    <button type="button" class="btn-action btn-quickview"
                                                            data-product-id="{{ $product->id }}"
                                                            aria-label="Quick view">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                </div>

                                                <!-- Product Badges -->
                                                <div class="product-badges">
                                                    @if($product->is_featured)
                                                        <span class="badge badge-featured">Featured</span>
                                                    @endif

                                                    @if($product->is_on_sale)
                                                        <span class="badge badge-sale">Sale</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Product Info -->
                                            <div class="product-info">
                                                <h2 class="product-title">
                                                    <a href="{{ route('products.show', $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h2>

                                                <div class="product-category">
                                                    <a href="{{ route('categories.show', $product->category->slug) }}" class="text-muted">
                                                        {{ $product->category->name }}
                                                    </a>
                                                </div>
                                                <!-- Product Actions -->
                                                <div class="product-buttons">
                                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if($products->hasPages())
                                <div class="pagination-container mt-5">
                                    {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @endif
                        @else
                            <!-- No Products Found -->
                            <div class="no-products">
                                <div class="no-products-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h2>No Products Found</h2>
                                <p>We couldn't find any products matching your criteria.</p>
                                <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-primary">
                                    Clear Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickViewModalLabel">Product Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="quick-view-loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="quick-view-content">
                        <!-- Content loaded via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Need Assistance Floating Panel -->
    <div class="assistance-panel">
        <div class="assistance-header">
            <div class="assistance-icon">
                <i class="fas fa-headset"></i>
            </div>
            <h3>Need Assistance?</h3>
        </div>
        <div class="assistance-content">
            <p>Our product specialists are ready to help you find the perfect solution.</p>
            <div class="assistance-contact">
                <a href="tel:+255676111700" class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+255 676 111 700</span>
                </a>
                <a href="mailto:info@simbadw.co.tz" class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@simbadw.co.tz</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary: #deaf33;
            --primary-dark: #c69c2c;
            --primary-light: #f0e8c8;
            --secondary: #333;
            --text-dark: #222;
            --text-body: #555;
            --text-light: #777;
            --border-color: #e0e0e0;
            --background-light: #f8f9fa;
            --surface: #fff;
            --shadow-sm: 0 2px 5px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.1);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        /* Category Featured Image */
        .category-featured-image {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .category-featured-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .category-featured-image:hover img {
            transform: scale(1.05);
        }

        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            color: white;
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        /* Sidebar Cards */
        .sidebar-container {
            position: sticky;
            top: 20px;
        }

        .sidebar-card {
            background-color: var(--surface);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .sidebar-card-header {
            padding: 1rem 1.25rem;
            background-color: var(--background-light);
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .sidebar-card-body {
            padding: 1.25rem;
        }

        /* Category Navigation */
        .category-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-nav li {
            border-bottom: 1px solid var(--border-color);
        }

        .category-nav li:last-child {
            border-bottom: none;
        }

        .category-nav li a {
            display: flex;
            align-items: center;
            padding: 0.75rem 0.5rem;
            color: var(--text-body);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .category-nav li a:hover {
            background-color: var(--background-light);
            color: var(--primary);
        }

        .category-nav li.active a {
            color: var(--primary);
            font-weight: 600;
        }

        /* Parent and subcategory styles */
        .parent-category > a {
            font-weight: 500;
        }

        .subcategory-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: var(--background-light);
            border-top: 1px solid var(--border-color);
            display: block;
        }

        .subcategory-nav li a {
            padding-left: 2rem;
            font-size: 0.95rem;
        }

        .subcategory-nav li.active a {
            color: var(--primary);
            font-weight: 600;
            background-color: rgba(222, 175, 51, 0.1);
        }

        .subcategory-link:hover {
            background-color: rgba(222, 175, 51, 0.05);
        }

        /* Subcategories Grid */
        .subcategories-grid {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .subcategory-card {
            display: block;
            text-decoration: none;
            background-color: var(--surface);
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            height: 100%;
            transition: all 0.3s ease;
        }

        .subcategory-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .subcategory-image {
            position: relative;
            padding-top: 75%;
            background-color: var(--background-light);
            overflow: hidden;
        }

        .subcategory-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .subcategory-card:hover .subcategory-image img {
            transform: scale(1.1);
        }

        .subcategory-icon {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--text-light);
        }

        .subcategory-name {
            padding: 1rem;
            text-align: center;
            font-weight: 500;
            color: var(--text-dark);
            border-top: 1px solid var(--border-color);
            transition: color 0.2s ease;
        }

        .subcategory-card:hover .subcategory-name {
            color: var(--primary);
        }

        /* Form Controls */
        .form-select {
            height: 42px;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            border-color: var(--border-color);
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(222, 175, 51, 0.25);
        }

        /* Active Filters */
        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 0.5rem;
        }

        .filter-tag {
            display: inline-flex;
            align-items: center;
            background-color: var(--background-light);
            border: 1px solid var(--border-color);
            border-radius: 30px;
            padding: 5px 12px;
            font-size: 0.85rem;
            color: var(--text-body);
        }

        .filter-remove {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            margin-left: 6px;
            background-color: rgba(0,0,0,0.05);
            border-radius: 50%;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .filter-remove:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Product Category Header */
        .category-header {
            margin-bottom: 2rem;
        }

        .category-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .category-description {
            color: var(--text-body);
            line-height: 1.6;
            white-space: pre-line;
        }

        /* Products Toolbar */
        .products-toolbar {
            margin-bottom: 1.5rem;
        }

        .products-count {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        /* Product Cards */
        .product-card {
            background-color: var(--surface);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid var(--border-color);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .product-image-container {
            position: relative;
            padding-top: 100%; /* 1:1 Aspect Ratio */
            overflow: hidden;
            background-color: var(--background-light);
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        /* Product Actions */
        .product-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 1;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--surface);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-body);
            font-size: 0.9rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-action:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Product Badges */
        .product-badges {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            z-index: 1;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-featured {
            background-color: var(--primary);
            color: white;
        }

        .badge-sale {
            background-color: #ff6b6b;
            color: white;
        }

        /* Product Info */
        .product-info {
            padding: 1.25rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 0.75rem;
            height: 3.1rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-title a {
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .product-title a:hover {
            color: var(--primary);
        }

        .product-category {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .product-category a {
            color: var(--text-light);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .product-category a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Product Price */
        .product-price {
            margin-bottom: 1rem;
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .regular-price {
            color: var(--text-light);
            font-size: 0.9rem;
            text-decoration: line-through;
        }

        .sale-price {
            color: var(--primary);
            font-size: 1.2rem;
            font-weight: 700;
        }

        .current-price {
            color: var(--primary);
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* Product Buttons */
        .product-buttons {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
        }

        .product-buttons .btn {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            flex-grow: 1;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            width: 40px;
            padding: 0;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        /* View Toggle */
        .view-switcher .btn-group {
            box-shadow: var(--shadow-sm);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .view-switcher .btn {
            border-radius: 0;
            padding: 0.35rem 0.75rem;
        }

        .view-switcher .btn.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* No Products */
        .no-products {
            background-color: var(--surface);
            border-radius: var(--radius-md);
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
            border: 1px dashed var(--border-color);
        }

        .no-products-icon {
            font-size: 3rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        .no-products h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .no-products p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        /* Assistance Panel */
        .assistance-panel {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 300px;
            background-color: var(--primary);
            color: white;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
            z-index: 100;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .assistance-panel.hidden {
            transform: translateY(100%);
            opacity: 0;
        }

        .assistance-header {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            background-color: rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .assistance-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .assistance-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .assistance-content {
            padding: 20px;
            display: none;
        }

        .assistance-content p {
            margin-bottom: 15px;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .assistance-contact {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s ease;
        }

        .contact-item:hover {
            opacity: 0.8;
            color: white;
        }

        .contact-item i {
            width: 30px;
            height: 30px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .sidebar-container {
                position: static;
            }

            .products-count {
                margin-bottom: 0.5rem;
            }

            #products-container.list-view .product-card {
                flex-direction: column;
            }

            #products-container.list-view .product-image-container {
                max-width: 100%;
                padding-top: 100%;
                height: auto;
            }

            .assistance-panel {
                bottom: 20px;
                right: 20px;
                width: 250px;
            }
        }

        @media (max-width: 767.98px) {
            .product-title {
                font-size: 1rem;
            }

            .products-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .products-count {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize View Switcher
            initViewSwitcher();

            // Initialize Quick View
            initQuickView();

            // Initialize Wishlist
            initWishlist();

            // Initialize Assistance Panel
            initAssistancePanel();

            // Initialize Category Navigation
            initCategoryNavigation();

            /**
             * Initialize View Switcher (Grid/List)
             */
            function initViewSwitcher() {
                const gridViewBtn = document.getElementById('grid-view');
                const listViewBtn = document.getElementById('list-view');
                const productsContainer = document.getElementById('products-container');

                if (gridViewBtn && listViewBtn && productsContainer) {
                    // Check localStorage for saved view preference
                    const viewMode = localStorage.getItem('viewMode') || 'grid';

                    if (viewMode === 'list') {
                        productsContainer.classList.add('list-view');
                        gridViewBtn.classList.remove('active');
                        listViewBtn.classList.add('active');
                    }

                    // Grid view click
                    gridViewBtn.addEventListener('click', function() {
                        productsContainer.classList.remove('list-view');
                        gridViewBtn.classList.add('active');
                        listViewBtn.classList.remove('active');
                        localStorage.setItem('viewMode', 'grid');
                    });

                    // List view click
                    listViewBtn.addEventListener('click', function() {
                        productsContainer.classList.add('list-view');
                        gridViewBtn.classList.remove('active');
                        listViewBtn.classList.add('active');
                        localStorage.setItem('viewMode', 'list');
                    });
                }
            }

            /**
             * Initialize Category Navigation
             */
            function initCategoryNavigation() {
                // Handle parent category clicks to show/hide subcategories
                const parentLinks = document.querySelectorAll('.parent-link[data-has-children="true"]');

                parentLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Only prevent default if the parent is not already active
                        if (!this.closest('li').classList.contains('active')) {
                            e.preventDefault();

                            // Toggle chevron icon
                            const icon = this.querySelector('i.fas');
                            if (icon.classList.contains('fa-chevron-right')) {
                                icon.classList.remove('fa-chevron-right');
                                icon.classList.add('fa-chevron-down');
                            } else {
                                icon.classList.remove('fa-chevron-down');
                                icon.classList.add('fa-chevron-right');
                            }

                            // Create or show subcategory list
                            const parentLi = this.closest('li');

                            // Get parent category ID
                            const parentId = this.getAttribute('href').split('/').pop();

                            // Check if subcategory list already exists
                            let subcatList = parentLi.querySelector('.subcategory-nav');

                            if (subcatList) {
                                // Toggle visibility
                                if (subcatList.style.display === 'none') {
                                    subcatList.style.display = 'block';
                                } else {
                                    subcatList.style.display = 'none';
                                }
                            } else {
                                // If no existing list, redirect to the category page
                                window.location.href = this.getAttribute('href');
                            }
                        }
                    });
                });
            }

            /**
             * Initialize Quick View Modal
             */
            function initQuickView() {
                const quickViewBtns = document.querySelectorAll('.btn-quickview');
                const quickViewModal = document.getElementById('quickViewModal');

                if (quickViewBtns.length && quickViewModal) {
                    const modal = new bootstrap.Modal(quickViewModal);
                    const modalContent = quickViewModal.querySelector('.quick-view-content');
                    const loadingElement = quickViewModal.querySelector('.quick-view-loading');

                    quickViewBtns.forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();

                            const productId = this.getAttribute('data-product-id');

                            // Show loading and hide content
                            loadingElement.style.display = 'block';
                            modalContent.style.display = 'none';
                            modalContent.innerHTML = '';

                            // Show modal
                            modal.show();

                            // Fetch product details
                            fetch(`/api/products/${productId}/quick-view`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.text();
                                })
                                .then(html => {
                                    // Hide loading and show content
                                    loadingElement.style.display = 'none';
                                    modalContent.style.display = 'block';
                                    modalContent.innerHTML = html;

                                    // Initialize any sliders or other components inside the modal
                                    initModalComponents();
                                })
                                .catch(error => {
                                    console.error('Quick view error:', error);
                                    loadingElement.style.display = 'none';
                                    modalContent.style.display = 'block';
                                    modalContent.innerHTML = `
                                    <div class="alert alert-danger">
                                        Failed to load product details. Please try again.
                                    </div>
                                `;
                                });
                        });
                    });

                    // Initialize components inside the modal
                    function initModalComponents() {
                        // Initialize product image slider if exists
                        const imageSlider = modalContent.querySelector('.product-slider');
                        if (imageSlider) {
                            new bootstrap.Carousel(imageSlider);
                        }

                        // Initialize quantity controls
                        const quantityInput = modalContent.querySelector('.quantity-input');
                        if (quantityInput) {
                            const minusBtn = modalContent.querySelector('.btn-quantity-minus');
                            const plusBtn = modalContent.querySelector('.btn-quantity-plus');

                            minusBtn.addEventListener('click', () => {
                                const value = parseInt(quantityInput.value, 10);
                                if (value > 1) {
                                    quantityInput.value = value - 1;
                                }
                            });

                            plusBtn.addEventListener('click', () => {
                                const value = parseInt(quantityInput.value, 10);
                                const max = parseInt(quantityInput.getAttribute('max'), 10) || 99;
                                if (value < max) {
                                    quantityInput.value = value + 1;
                                }
                            });
                        }
                    }
                }
            }

            /**
             * Initialize Wishlist Functionality
             */
            function initWishlist() {
                const wishlistBtns = document.querySelectorAll('.btn-wishlist');

                wishlistBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const isActive = this.classList.contains('active');

                        if (isActive) {
                            this.classList.remove('active');
                            this.innerHTML = '<i class="far fa-heart"></i>';
                            showToast('Product removed from wishlist', 'info');
                        } else {
                            this.classList.add('active');
                            this.innerHTML = '<i class="fas fa-heart"></i>';
                            showToast('Product added to wishlist', 'success');
                        }

                        // Animation effect
                        this.classList.add('pulse');
                        setTimeout(() => {
                            this.classList.remove('pulse');
                        }, 500);
                    });
                });
            }

            /**
             * Initialize Assistance Panel
             */
            function initAssistancePanel() {
                const assistancePanel = document.querySelector('.assistance-panel');
                const assistanceHeader = document.querySelector('.assistance-header');
                const assistanceContent = document.querySelector('.assistance-content');

                if (assistancePanel && assistanceHeader && assistanceContent) {
                    // Check if panel should be expanded based on localStorage
                    const isPanelExpanded = localStorage.getItem('assistancePanelExpanded') === 'true';

                    if (isPanelExpanded) {
                        assistanceContent.style.display = 'block';
                    }

                    // Toggle panel on header click
                    assistanceHeader.addEventListener('click', function() {
                        if (assistanceContent.style.display === 'block') {
                            assistanceContent.style.display = 'none';
                            localStorage.setItem('assistancePanelExpanded', 'false');
                        } else {
                            assistanceContent.style.display = 'block';
                            localStorage.setItem('assistancePanelExpanded', 'true');
                        }
                    });

                    // Close panel when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!assistancePanel.contains(event.target) && assistanceContent.style.display === 'block') {
                            assistanceContent.style.display = 'none';
                            localStorage.setItem('assistancePanelExpanded', 'false');
                        }
                    });
                }
            }

            /**
             * Show Toast Notification
             */
            function showToast(message, type = 'success') {
                // Create toast container if it doesn't exist
                let toastContainer = document.querySelector('.toast-container');

                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                    document.body.appendChild(toastContainer);
                }

                // Create toast element
                const toastId = 'toast-' + Date.now();
                const toast = document.createElement('div');
                toast.className = `toast ${type === 'success' ? 'bg-success' : 'bg-primary'} text-white`;
                toast.id = toastId;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');

                const icon = type === 'success' ? 'check-circle' :
                    type === 'info' ? 'info-circle' :
                        type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle';

                toast.innerHTML = `
                <div class="toast-header bg-${type === 'success' ? 'success' : 'primary'} text-white">
                    <i class="fas fa-${icon} me-2"></i>
                    <strong class="me-auto">${type === 'success' ? 'Success' : 'Information'}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;

                // Add to container
                toastContainer.appendChild(toast);

                // Initialize and show the toast
                const bsToast = new bootstrap.Toast(toast, {
                    autohide: true,
                    delay: 3000
                });

                bsToast.show();

                // Remove from DOM after hiding
                toast.addEventListener('hidden.bs.toast', function() {
                    toast.remove();
                });
            }

            // Add pulse animation for wishlist buttons
            const style = document.createElement('style');
            style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }

            .pulse {
                animation: pulse 0.5s ease-in-out;
            }
        `;
            document.head.appendChild(style);
        });
    </script>
@endpush
