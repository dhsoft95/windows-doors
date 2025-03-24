@extends('layouts.app')
@section('content')
    <div class="page-category py-5">
        <div class="container">
            <!-- Modified Header Section with Description on Right -->
            <div class="row mb-5 align-items-center">
                <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                    <h1 class="category-title mb-3">{{ $category->name }}</h1>
                    <div class="separator mb-4"></div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="category-description">
                        {!! nl2br(e($category->description)) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Simplified Sidebar with Better Spacing -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="sidebar-container">
                        <!-- Filter Panel with Clearer Structure -->
                        <div class="sidebar-card">
                            <h3 class="sidebar-title">
                                <i class="fa-solid fa-filter me-2"></i>Filter Options
                            </h3>
                            <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="filter-form">
                                <!-- Sort Options with Improved Select -->
                                <div class="form-group mb-3">
                                    <label for="sort-select" class="form-label fw-medium">Sort By</label>
                                    <select id="sort-select" name="sort" class="form-select">
                                        <option value="">Default</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            Price: Low to High
                                        </option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            Price: High to Low
                                        </option>
                                    </select>
                                </div>

                                <!-- Apply Button with Better Contrast -->
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-check me-2"></i> Apply Filters
                                </button>
                            </form>

                            <!-- Active Filters with Better Visual Indication -->
                            @if(request()->filled('sort'))
                                <div class="active-filters mt-4">
                                    <h4 class="filters-title">Active Filters</h4>
                                    <div class="filter-tags">
                                        <span class="filter-tag">
                                            <span class="tag-text">{{ request('sort') == 'price_asc' ? 'Low to High' : 'High to Low' }}</span>
                                            <a href="{{ route('categories.show', $category->slug) }}" class="remove-filter" aria-label="Remove filter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Categories Card with Improved Navigation -->
                        <div class="sidebar-card">
                            <h3 class="sidebar-title">
                                <i class="fa-solid fa-folder me-2"></i>Categories
                            </h3>
                            <ul class="category-nav">
                                @foreach($categories as $cat)
                                    <li class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                        <a href="{{ route('categories.show', $cat->slug) }}">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Support Box with Improved Readability -->
                        <div class="support-card">
                            <h3 class="support-title">Need Help?</h3>
                            <div class="support-contacts">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div class="contact-text">
                                        <a href="tel:+255676111700">+255 676 111 700</a>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div class="contact-text">
                                        <a href="mailto:info@simbadw.co.tz">info@simbadw.co.tz</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Improved Products Grid with Better Visual Hierarchy -->
                <div class="col-lg-9">
                    <!-- Products Display with Card-Based Layout -->
                    <div class="products-grid">
                        @if($products->count() > 0)
                            <div class="row g-4">
                                @foreach($products as $product)
                                    <div class="col-xl-4 col-md-6">
                                        <div class="product-card">
                                            <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                                                <div class="product-image-wrapper">
                                                    @if($product->main_image)
                                                        <img src="{{ asset('storage/' . $product->main_image) }}"
                                                             alt="{{ $product->name }}"
                                                             class="product-image"
                                                             data-magnify="true"
                                                             data-src="{{ asset('storage/' . $product->main_image) }}">
                                                    @else
                                                        <img src="{{ asset('images/placeholder.jpg') }}"
                                                             alt="{{ $product->name }}"
                                                             class="product-image">
                                                    @endif

                                                    <!-- Visual Overlay for Focus -->
                                                    <div class="image-overlay">
                                                        <span class="overlay-icon"><i class="fas fa-eye"></i></span>
                                                    </div>

                                                    <!-- Product Badges with Improved Visibility -->
                                                    @if($product->is_on_sale)
                                                        <div class="product-badge sale-badge">
                                                            {{ $product->discount_percentage }}% OFF
                                                        </div>
                                                    @endif

                                                    @if(!$product->is_in_stock)
                                                        <div class="product-badge stock-badge">
                                                            Out of Stock
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>

                                            <div class="product-info">
                                                <!-- Title with Better Typography -->
                                                <h2 class="product-title">
                                                    <a href="{{ route('products.show', $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h2>

                                                <!-- Description with Improved Readability -->
                                                @if($product->short_description)
                                                    <div class="product-description">
                                                        {{ Str::limit($product->short_description, 100) }}
                                                    </div>
                                                @endif

                                                <!-- Product Details with Better Organization -->
                                                <div class="product-meta">
                                                    <!-- Stock Status with Clearer Indicators -->
                                                    <div class="stock-status">
                                                        <span class="status-indicator {{ $product->is_in_stock ? 'in-stock' : 'out-of-stock' }}">
                                                            <i class="fas fa-{{ $product->is_in_stock ? 'check-circle' : 'times-circle' }} me-1"></i>
                                                            {{ $product->is_in_stock ? 'In Stock' : 'Out of Stock' }}
                                                        </span>
                                                        @if($product->is_in_stock && isset($product->stock_quantity))
                                                            <span class="stock-quantity">({{ $product->stock_quantity }} available)</span>
                                                        @endif
                                                    </div>

                                                    <!-- Star Rating with More Accessible Design -->
                                                    @if($product->average_rating)
                                                        <div class="product-rating">
                                                            <div class="rating-stars" aria-label="Product rated {{ $product->average_rating }} out of 5 stars">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star {{ $i <= $product->average_rating ? 'filled' : '' }}"></i>
                                                                @endfor
                                                            </div>
                                                            <span class="review-count">({{ $product->reviews_count }})</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Action Buttons with Better Visual Hierarchy -->
                                                <div class="product-actions">
                                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-view">
                                                        View Details
                                                    </a>
                                                    @if($product->is_in_stock)
                                                        <button class="btn btn-secondary btn-quick-view"
                                                                data-product-id="{{ $product->id }}"
                                                                title="Quick View"
                                                                aria-label="Quick view of {{ $product->name }}">
                                                            <i class="fas fa-search-plus"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination with Improved Layout -->
                            <div class="pagination-wrapper mt-5">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="pagination-info mb-3 mb-md-0">
                                        Showing <strong>{{ $products->firstItem() }}-{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products
                                    </div>
                                    {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        @else
                            <!-- Empty State with Better Visual Design -->
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h2 class="empty-title">No Products Found</h2>
                                <p class="empty-message">We couldn't find any products in this category currently.</p>
                                <div class="empty-actions">
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-th-large me-2"></i>Browse Categories
                                    </a>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag me-2"></i>View All Products
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Base Layout Improvements */
        .page-category {
            padding: 60px 0;
            color: #333;
        }

        /* Category Title & Description Layout */
        .category-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #222;
            letter-spacing: -0.5px;
            line-height: 1.2;
            position: relative;
        }

        .separator {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #deaf33, #e8c655);
            border-radius: 2px;
            margin: 1.5rem 0;
        }

        .category-description {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
            text-align: left;
            padding-left: 1.5rem;
            border-left: 1px solid #eee;
        }

        /* Preserve bullet points and formatting */
        .category-description {
            white-space: pre-line;
        }

        /* Style for bullet points to ensure they display properly */
        .category-description ul,
        .category-description ul li,
        .category-description ol,
        .category-description ol li {
            list-style-position: outside;
            margin-left: 1.5rem;
        }

        @media (max-width: 767.98px) {
            .category-title {
                font-size: 2rem;
                text-align: center;
            }

            .separator {
                margin: 1.5rem auto;
            }

            .category-description {
                padding-left: 0;
                border-left: none;
            }
        }

        /* Separator Styling */
        .separator {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #deaf33, #e8c655);
            border-radius: 2px;
            margin: 2rem auto;
        }

        /* Sidebar Improvements */
        .sidebar-container {
            position: sticky;
            top: 30px;
        }

        .sidebar-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #f0f0f0;
        }

        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        /* Form Elements Improvements */
        .form-label {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .form-select {
            height: 45px;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
            border-color: #e0e0e0;
            box-shadow: none;
            transition: all 0.2s;
        }

        .form-select:focus {
            border-color: #deaf33;
            box-shadow: 0 0 0 0.25rem rgba(222, 175, 51, 0.25);
        }

        /* Button Styling */
        .btn {
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #deaf33;
            border-color: #deaf33;
            color: #fff;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #c69c2c;
            border-color: #c69c2c;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(222, 175, 51, 0.2);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            border-color: #e0e0e0;
            color: #555;
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
            color: #333;
        }

        .btn-outline-primary {
            border-color: #deaf33;
            color: #deaf33;
        }

        .btn-outline-primary:hover {
            background-color: #deaf33;
            color: #fff;
        }

        /* Active Filters Styling */
        .active-filters {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px dashed #eee;
        }

        .filters-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #555;
        }

        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filter-tag {
            display: inline-flex;
            align-items: center;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 30px;
            padding: 6px 12px;
            font-size: 0.85rem;
            color: #555;
            transition: all 0.2s;
        }

        .filter-tag:hover {
            background-color: #f0f0f0;
        }

        .tag-text {
            margin-right: 6px;
        }

        .remove-filter {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            background-color: rgba(0,0,0,0.1);
            border-radius: 50%;
            color: #777;
            transition: all 0.2s;
        }

        .remove-filter:hover {
            background-color: #ff5252;
            color: #fff;
        }

        /* Category Navigation */
        .category-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-nav li {
            border-bottom: 1px solid #f0f0f0;
        }

        .category-nav li:last-child {
            border-bottom: none;
        }

        .category-nav li a {
            display: block;
            padding: 10px 0;
            color: #555;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .category-nav li a:hover {
            color: #deaf33;
            padding-left: 5px;
        }

        .category-nav li.active a {
            color: #deaf33;
            font-weight: 600;
        }

        /* Support Card */
        .support-card {
            background: linear-gradient(135deg, #deaf33, #e8c655);
            border-radius: 12px;
            padding: 1.5rem;
            color: #fff;
            box-shadow: 0 6px 15px rgba(222, 175, 51, 0.2);
        }

        .support-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            color: #fff;
        }

        .support-contacts {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
        }

        .contact-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            margin-right: 12px;
        }

        .contact-text a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .contact-text a:hover {
            color: rgba(255,255,255,0.8);
            text-decoration: underline;
        }

        /* Product Card Improvements */
        .product-card {
            height: 100%;
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }

        .product-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            padding-top: 75%;
            background-color: #f8f9fa;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        /* Overlay Effect */
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.3);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .image-overlay {
            opacity: 1;
        }

        .overlay-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: #fff;
            color: #deaf33;
            border-radius: 50%;
            font-size: 1.25rem;
            transform: scale(0.8);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card:hover .overlay-icon {
            transform: scale(1);
            opacity: 1;
        }

        /* Product Badges */
        .product-badge {
            position: absolute;
            z-index: 5;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        .sale-badge {
            top: 10px;
            right: 10px;
            background-color: #ff5252;
            color: #fff;
        }

        .stock-badge {
            top: 10px;
            right: 10px;
            background-color: #333;
            color: #fff;
        }

        /* Product Info Area */
        .product-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 0.75rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
        }

        .product-title a:hover {
            color: #deaf33;
        }

        .product-description {
            color: #777;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Product Metadata */
        .product-meta {
            margin: 1rem 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: auto;
        }

        .stock-status {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 0.9rem;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 500;
        }

        .in-stock {
            background-color: rgba(76, 175, 80, 0.15);
            color: #4caf50;
        }

        .out-of-stock {
            background-color: rgba(244, 67, 54, 0.15);
            color: #f44336;
        }

        .stock-quantity {
            color: #777;
            font-size: 0.85rem;
        }

        /* Rating Stars */
        .product-rating {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating-stars {
            display: flex;
        }

        .rating-stars i {
            color: #ddd;
            font-size: 0.9rem;
            margin-right: 2px;
        }

        .rating-stars i.filled {
            color: #ffc107;
        }

        .review-count {
            color: #777;
            font-size: 0.85rem;
        }

        /* Action Buttons */
        .product-actions {
            margin-top: 1.25rem;
            display: flex;
            gap: 8px;
        }

        .btn-view {
            flex-grow: 1;
        }

        .btn-quick-view {
            width: 45px;
            padding: 0;
        }

        /* Empty State */
        .empty-state {
            background-color: #fff;
            border-radius: 12px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px dashed #e0e0e0;
        }

        .empty-icon {
            font-size: 3rem;
            color: #deaf33;
            opacity: 0.5;
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .empty-message {
            color: #777;
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 1.5rem;
        }

        .empty-actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Pagination Improvements */
        .pagination-wrapper {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }

        .pagination-info {
            color: #777;
            font-size: 0.95rem;
        }

        .page-link {
            color: #deaf33;
            border-radius: 6px;
            margin: 0 3px;
        }

        .page-item.active .page-link {
            background-color: #deaf33;
            border-color: #deaf33;
        }

        /* Magnifier Glass Improvements */
        .img-magnifier-glass {
            position: absolute;
            border: 3px solid #deaf33;
            border-radius: 50%;
            cursor: none;
            width: 150px;
            height: 150px;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .sidebar-container {
                position: static;
                margin-bottom: 2rem;
            }

            .support-card {
                margin-bottom: 0;
            }
        }

        @media (max-width: 767.98px) {
            .category-title {
                font-size: 2rem;
            }

            .pagination-wrapper {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .product-actions {
                flex-direction: column;
            }

            .btn-quick-view {
                width: 100%;
                height: 40px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image magnifier with improved performance
            initImageMagnifier();

            // Initialize quick view functionality
            initQuickView();

            // Initialize image magnifier
            function initImageMagnifier() {
                const magnifyImages = document.querySelectorAll('img[data-magnify="true"]');

                if (magnifyImages.length > 0) {
                    magnifyImages.forEach(img => {
                        // Wait for image to load to ensure proper dimensions
                        if (img.complete) {
                            setupMagnifier(img);
                        } else {
                            img.onload = function() {
                                setupMagnifier(img);
                            };
                        }
                    });
                }
            }

            function setupMagnifier(img) {
                // Create magnifier glass
                const glass = document.createElement('div');
                glass.setAttribute('class', 'img-magnifier-glass');
                img.parentElement.appendChild(glass);

                // Set background image from data-src attribute
                const imgSrc = img.getAttribute('data-src');
                glass.style.backgroundImage = `url('${imgSrc}')`;
                glass.style.backgroundRepeat = "no-repeat";
                glass.style.backgroundSize = (img.width * 3) + "px " + (img.height * 3) + "px";

                // Hide glass initially
                glass.style.display = "none";

                // Add mouse events with improved performance
                img.addEventListener('mousemove', throttle(function(e) {
                    moveMagnifier(e, img, glass);
                }, 10));

                img.addEventListener('mouseenter', function() {
                    glass.style.display = "block";
                });

                img.addEventListener('mouseleave', function() {
                    glass.style.display = "none";
                });
            }

            // Throttle function to improve performance
            function throttle(callback, delay) {
                let previousCall = new Date().getTime();
                return function() {
                    const time = new Date().getTime();

                    if ((time - previousCall) >= delay) {
                        previousCall = time;
                        callback.apply(null, arguments);
                    }
                };
            }

            function moveMagnifier(e, img, glass) {
                // Prevent default browser behavior
                e.preventDefault();

                // Get cursor position
                const pos = getCursorPos(e, img);
                let x = pos.x;
                let y = pos.y;

                // Boundary checking
                if (x > img.width - (glass.offsetWidth / 2)) {
                    x = img.width - (glass.offsetWidth / 2);
                }
                if (x < (glass.offsetWidth / 2)) {
                    x = (glass.offsetWidth / 2);
                }
                if (y > img.height - (glass.offsetHeight / 2)) {
                    y = img.height - (glass.offsetHeight / 2);
                }
                if (y < (glass.offsetHeight / 2)) {
                    y = (glass.offsetHeight / 2);
                }

                // Position the magnifier glass
                glass.style.left = (x - glass.offsetWidth / 2) + "px";
                glass.style.top = (y - glass.offsetHeight / 2) + "px";

                // Set the background position
                const magFactor = 3; // Magnification factor
                glass.style.backgroundPosition = "-" + ((x * magFactor) - glass.offsetWidth / 2) + "px -" +
                    ((y * magFactor) - glass.offsetHeight / 2) + "px";
            }

            function getCursorPos(e, img) {
                const rect = img.getBoundingClientRect();
                const x = e.pageX - rect.left - window.pageXOffset;
                const y = e.pageY - rect.top - window.pageYOffset;
                return {x: x, y: y};
            }

            // Initialize quick view functionality
            function initQuickView() {
                const quickViewButtons = document.querySelectorAll('.btn-quick-view');

                if (quickViewButtons.length > 0) {
                    quickViewButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const productId = this.getAttribute('data-product-id');

                            // Implement quick view modal - can be expanded based on requirements
                            showQuickViewModal(productId);
                        });
                    });
                }
            }

            // Show quick view modal
            function showQuickViewModal(productId) {
                // This function can be implemented to show a modal with product details
                // using AJAX to fetch product information
                console.log('Quick view modal for product ID:', productId);

                // Example implementation (placeholder):
                // 1. Create or show modal container
                let modal = document.getElementById('quick-view-modal');
                if (!modal) {
                    modal = document.createElement('div');
                    modal.id = 'quick-view-modal';
                    modal.className = 'product-quick-view-modal';
                    modal.innerHTML = `
                        <div class="modal-overlay"></div>
                        <div class="modal-container">
                            <div class="modal-header">
                                <h3>Quick View</h3>
                                <button class="close-modal">&times;</button>
                            </div>
                            <div class="modal-content">
                                <div class="loading-spinner">Loading...</div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);

                    // Add close functionality
                    const closeBtn = modal.querySelector('.close-modal');
                    const overlay = modal.querySelector('.modal-overlay');

                    closeBtn.addEventListener('click', function() {
                        modal.classList.remove('active');
                    });

                    overlay.addEventListener('click', function() {
                        modal.classList.remove('active');
                    });
                }

                // 2. Show the modal
                modal.classList.add('active');

                // 3. In a real implementation, you would fetch product data here
                // Example: fetch(`/api/products/${productId}/quick-view`)
            }

            // Add responsive menu toggle if needed
            function initResponsiveMenu() {
                const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
                const sidebarContainer = document.querySelector('.sidebar-container');

                if (mobileFilterToggle && sidebarContainer) {
                    mobileFilterToggle.addEventListener('click', function() {
                        sidebarContainer.classList.toggle('active');
                    });
                }
            }

            // Initialize any additional functionality here
            function initAdditionalFunctionality() {
                // Add smooth scrolling for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        const targetId = this.getAttribute('href');
                        if (targetId !== '#') {
                            const targetElement = document.querySelector(targetId);
                            if (targetElement) {
                                e.preventDefault();
                                window.scrollTo({
                                    top: targetElement.offsetTop - 80,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    });
                });

                // Add lazy loading for images if needed
                if ('loading' in HTMLImageElement.prototype) {
                    const images = document.querySelectorAll('img[loading="lazy"]');
                    images.forEach(img => {
                        img.src = img.dataset.src;
                    });
                } else {
                    // Load a lazy loading polyfill
                    // This would be implemented in a production environment
                }
            }

            // Call initialization functions
            initResponsiveMenu();
            initAdditionalFunctionality();
        });
    </script>
@endpush

<!-- Add these styles to make the quick view modal work -->
@push('styles')
    <style>
        /* Quick View Modal Styles */
        .product-quick-view-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1050;
        }

        .product-quick-view-modal.active {
            display: block;
        }

        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal-container {
            position: relative;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            margin: 5vh auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideIn 0.3s ease;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            line-height: 1;
            color: #777;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-modal:hover {
            color: #333;
        }

        .modal-content {
            padding: 1.5rem;
            overflow-y: auto;
            max-height: calc(90vh - 60px);
        }

        .loading-spinner {
            text-align: center;
            padding: 2rem;
            color: #777;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Mobile Filter Toggle */
        .mobile-filter-toggle {
            display: none;
        }

        @media (max-width: 991.98px) {
            .mobile-filter-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
                padding: 0.75rem 1.25rem;
                background-color: #f8f9fa;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                color: #555;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
            }

            .mobile-filter-toggle:hover {
                background-color: #deaf33;
                border-color: #deaf33;
                color: #fff;
            }

            .mobile-filter-toggle i {
                margin-right: 8px;
            }

            .sidebar-container {
                display: none;
            }

            .sidebar-container.active {
                display: block;
            }
        }
    </style>
@endpush
