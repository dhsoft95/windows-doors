@extends('layouts.app')

@section('content')
    <div class="products-page">
        <div class="container-fluid px-lg-5">
            <div class="row g-4">
                <!-- Left Sidebar Navigation -->
                <div class="col-lg-3 col-md-4">
                    <div class="sidebar-nav">
                        <h4 class="sidebar-title">Product Categories</h4>
                        <ul class="nav flex-column category-menu">
                            @foreach($categories as $category)
                                <li class="nav-item">
                                    <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                       class="nav-link {{ request('category') == $category->id ? 'active' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-lg-9 col-md-8">
                    <!-- Category Title -->
                    <div class="category-header">
                        <h1 class="mb-3">
                            @if(request('category'))
                                {{ $categories->firstWhere('id', request('category'))->name ?? 'Products' }}
                            @else
                                All Products
                            @endif
                        </h1>

                        @if(request('category') && $categories->firstWhere('id', request('category'))->description)
                            <div class="category-description mb-3">
                                {!! $categories->firstWhere('id', request('category'))->description !!}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <p class="product-count mb-0">{{ $products->total() }} products available</p>

                            <!-- Optional Sort Dropdown -->
                            <div class="sort-options">
                                <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center">
                                    @if(request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    <label for="sort" class="me-2 text-nowrap">Sort by:</label>
                                    <select name="sort" id="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="">Default</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid">
                        <div class="row g-4">
                            @forelse($products as $product)
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="product-item">
                                        <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                                            <div class="product-image">
                                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                                     alt="{{ $product->name }}" >
                                            </div>
                                            <div class="product-title">
                                                <h3  class="product-model">{{ $product->name }}</h3>
{{--                                                <div class="product-model">{{ $product->model_number ?? 'SL 7050' }} – {{ $product->style_code ?? 'WINDOW ' . rand(10, 50) }}</div>--}}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="no-products">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            No products found in this category.
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($products->total() > 0)
                        <div class="pagination-container">
                            <div class="custom-pagination">
                                @if($products->onFirstPage())
                                    <span class="pagination-previous disabled">← Previous</span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="pagination-previous">← Previous</a>
                                @endif

                                @for($i = 1; $i <= $products->lastPage(); $i++)
                                    <a href="{{ $products->url($i) }}" class="pagination-number {{ $products->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                                @endfor

                                @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="pagination-next">Next →</a>
                                @else
                                    <span class="pagination-next disabled">Next →</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Base Styles */
        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .products-page {
            padding: 40px 0;
        }

        /* Additional enhancements */
        .row.g-4 {
            --bs-gutter-x: 20px;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            background-color: #fff;
            border-radius: 8px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f1f1;
            color: #222;
        }

        .category-menu {
            margin-bottom: 0;
        }

        .category-menu .nav-link {
            padding: 12px 15px;
            color: #555;
            font-size: 15px;
            border-radius: 6px;
            transition: all 0.2s ease;
            margin-bottom: 5px;
        }

        .category-menu .nav-link:hover {
            color: #deaf33;
            background-color: rgba(232, 65, 24, 0.05);
        }

        .category-menu .nav-link.active {
            color: #deaf33;
            background-color: rgba(232, 65, 24, 0.08);
            font-weight: 500;
        }

        /* Category Header */
        .category-header {
            margin-bottom: 30px;
            padding: 25px 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        }

        .category-header h1 {
            font-size: 32px;
            font-weight: 600;
            color: #222;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .category-description {
            color: #555;
            line-height: 1.6;
            max-width: 800px;
        }

        .product-count {
            color: #777;
            font-size: 14px;
        }

        .sort-options .form-select {
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            min-width: 180px;
        }

        /* Products Grid */
        .product-item {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .product-link {
            display: block;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        .product-image {
            background-color: #f9f9f9;
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: all 0.5s ease;
        }

        .product-item:hover .product-image img {
            transform: scale(1.05);
        }

        .product-title {
            text-align: center;
            padding: 20px;
        }

        .product-title h3 {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            margin: 0;
        }

        .product-model {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        /* Pagination - Updated Style */
        .pagination-container {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        }

        .pagination-previous, .pagination-next {
            display: inline-block;
            background-color: #deaf33;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 500;
            margin-right: 10px;
        }

        .pagination-next {
            margin-right: 0;
            margin-left: 10px;
        }

        .pagination-previous.disabled, .pagination-next.disabled {
            background-color: #deaf33;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .pagination-previous:hover:not(.disabled), .pagination-next:hover:not(.disabled) {
            background-color: #c23616;
        }

        .pagination-number {
            display: inline-block;
            width: 45px;
            height: 45px;
            line-height: 45px;
            text-align: center;
            margin-right: 5px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            background-color: #f5cfc0;
            transition: all 0.2s ease;
        }

        .pagination-number.active {
            background-color: #deaf33;
            color: white;
        }

        .pagination-number:hover:not(.active) {
            background-color: #f5b8a0;
        }

        .no-products {
            padding: 40px 0;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .sidebar-nav {
                margin-bottom: 25px;
            }

            .category-menu {
                display: flex;
                flex-wrap: wrap;
            }

            .category-menu .nav-item {
                width: auto;
                margin-right: 10px;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 767px) {
            .products-page {
                padding: 20px 0;
            }

            .category-header {
                padding: 15px;
            }

            .category-header h1 {
                font-size: 22px;
            }
        }

        .pagination-container {
            overflow-x: auto;
            padding-bottom: 15px;
        }

        .custom-pagination {
            min-width: max-content;
        }

        .sort-options {
            margin-top: 15px;
            width: 100%;
        }

        .sort-options .form-select {
            width: 100%;
        }
    </style>
@endpush
