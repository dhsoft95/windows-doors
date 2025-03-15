@extends('layouts.app')
@section('content')
    <div class="page-project-single py-5">
        <div class="container">
            <!-- Elegant Header Section -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="text-anime-style-3 mb-4">{{ $category->name }}</h2>
                    <p class="text-muted fs-5 mb-0">{{ $products->total() }} products in this collection</p>
                    <div class="separator mx-auto mt-4"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <!-- Filter Sidebar -->
                    <div class="project-single-sidebar">
                        <!-- Filter Panel -->
                        <div class="project-detail-list">
                            <div class="project-detail-title">
                                <h3>Filter Options</h3>
                            </div>

                            <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="filter-form">
                                <!-- Sort Options -->
                                <div class="project-detail-item">
                                    <div class="icon-box">
                                        <i class="fa-solid fa-sort"></i>
                                    </div>
                                    <div class="project-detail-content">
                                        <h3>Sort By</h3>
                                        <select name="sort" class="form-select custom-select">
                                            <option value="">Default</option>
                                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                                Price: Low to High
                                            </option>
                                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                                Price: High to Low
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Filter Apply Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i> Apply Filters
                                    </button>
                                </div>
                            </form>

                            <!-- Active Filters -->
                            @if(request()->filled('sort'))
                                <div class="project-detail-item mt-4">
                                    <div class="icon-box">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <div class="project-detail-content">
                                        <h3>Active Filters</h3>
                                        <div class="active-filters">
                                            <span class="filter-tag">
                                                Sort: {{ request('sort') == 'price_asc' ? 'Low to High' : 'High to Low' }}
                                                <a href="{{ route('categories.show', $category->slug) }}" class="remove-filter">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Categories Box -->
                        <div class="project-detail-list">
                            <div class="project-detail-title">
                                <h3>Categories</h3>
                            </div>
                            <div class="project-detail-item">
                                <div class="project-detail-content">
                                    <ul class="category-list">
                                        @foreach($categories as $cat)
                                            <li class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                                <a href="{{ route('categories.show', $cat->slug) }}">
                                                    {{ $cat->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Support CTA Box -->
                        <div class="sidebar-cta-box">
                            <div class="sidebar-cta-title">
                                <h2>Need Help?</h2>
                            </div>
                            <div class="sidebar-cta-contact">
                                <div class="sidebar-cta-contact-item">
                                    <div class="icon-box">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div class="cta-contact-item-content">
                                        <p>+255 676111700</p>
                                    </div>
                                </div>
                                <div class="sidebar-cta-contact-item">
                                    <div class="icon-box">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div class="cta-contact-item-content">
                                        <p>info@simbadw.co.tz</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- Products Grid -->
                    <div class="project-single-content">
                        <!-- Products Display -->
                        <div class="row g-4">
                            @forelse($products as $product)
                                <div class="col-md-6">
                                    <div class="project-gallery-item">
                                        <a href="{{ route('products.show', $product->slug) }}" class="gallery-link">
                                            <div class="product-image-container">
                                                @if($product->main_image)
                                                    <img src="{{ asset('storage/' . $product->main_image) }}"
                                                         alt="{{ $product->name }}"
                                                         class="product-image">
                                                @else
                                                    <img src="{{ asset('images/placeholder.jpg') }}"
                                                         alt="{{ $product->name }}"
                                                         class="product-image">
                                                @endif

                                                @if($product->is_on_sale)
                                                    <div class="badge-container sale">
                                                        <span class="sale-badge">{{ $product->discount_percentage }}% OFF</span>
                                                    </div>
                                                @endif

                                                @if(!$product->is_in_stock)
                                                    <div class="badge-container stock">
                                                        <span class="stock-badge">Out of Stock</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                        <div class="item-details">
                                            <h3 class="item-title">
                                                <a href="{{ route('products.show', $product->slug) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>

                                            <!-- Product Description -->
                                            @if($product->short_description)
                                                <div class="item-description">
                                                    {{ Str::limit($product->short_description, 120) }}
                                                </div>
                                            @endif

                                            <!-- Stock status -->
                                            <div class="item-stock">
                                                <span class="{{ $product->is_in_stock ? 'text-success' : 'text-danger' }}">
                                                    {{ $product->is_in_stock ? 'In Stock' : 'Out of Stock' }}
                                                </span>
                                                @if($product->is_in_stock && isset($product->stock_quantity))
                                                    ({{ $product->stock_quantity }} available)
                                                @endif
                                            </div>

                                            <!-- Rating if available -->
                                            @if($product->average_rating)
                                                <div class="item-rating">
                                                    <div class="stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $product->average_rating ? 'filled' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="review-count">({{ $product->reviews_count }})</span>
                                                </div>
                                            @endif

                                            <!-- Quick actions -->
                                            <div class="item-actions">
                                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary view-details">
                                                    View Details
                                                </a>
                                                @if($product->is_in_stock)
                                                    <button class="btn btn-outline-primary quick-view"
                                                            data-product-id="{{ $product->id }}"
                                                            title="Quick View">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="empty-results">
                                        <div class="empty-icon">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <h3>No Products Found</h3>
                                        <p>We couldn't find any products in this category. Try browsing <a href="{{ route('categories.index') }}">other categories</a> or <a href="{{ route('products.index') }}">view all products</a>.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Clean Pagination -->
                        @if($products->total() > 0)
                            <div class="pagination-container mt-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="page-info">
                                        Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}
                                    </div>
                                    {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
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
        /* Main Structure Styles */
        .page-project-single {
            padding: 80px 0;
        }

        .separator {
            width: 80px;
            height: 4px;
            background-color: #deaf33;
            margin-bottom: 30px;
        }

        /* Text Animation Style */
        .text-anime-style-3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
        }

        /* Sidebar Styles */
        .project-single-sidebar {
            margin-bottom: 30px;
        }

        .project-detail-list {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .project-detail-title {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .project-detail-title h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 0;
        }

        .project-detail-item {
            display: flex;
            margin-bottom: 20px;
        }

        .project-detail-item .icon-box {
            width: 45px;
            height: 45px;
            background-color: rgba(222, 175, 51, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .project-detail-item .icon-box i {
            color: #deaf33;
            font-size: 18px;
        }

        .project-detail-content {
            flex-grow: 1;
        }

        .project-detail-content h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .project-detail-content p {
            margin-bottom: 0;
            color: #777;
        }

        /* Category List */
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-list li a {
            color: #555;
            text-decoration: none;
            transition: all 0.3s;
            display: block;
        }

        .category-list li a:hover {
            color: #deaf33;
            padding-left: 5px;
        }

        .category-list li.active a {
            color: #deaf33;
            font-weight: 600;
        }

        /* Need Help Box */
        .sidebar-cta-box {
            background-color: #deaf33;
            border-radius: 10px;
            padding: 25px;
            color: #fff;
        }
        .sidebar-cta-title h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .sidebar-cta-contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .sidebar-cta-contact-item .icon-box {
            width: 45px;
            height: 45px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .sidebar-cta-contact-item p {
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Products Grid Styles */
        .project-gallery-item {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            height: 100%;
        }

        .project-gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Product Image Container */
        .product-image-container {
            position: relative;
            overflow: hidden;
            padding-top: 75%; /* 4:3 Aspect Ratio */
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .project-gallery-item:hover .product-image {
            transform: scale(1.05);
        }

        .item-details {
            padding: 20px;
        }

        .item-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .item-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        .item-title a:hover {
            color: #deaf33;
        }

        /* Description styling */
        .item-description {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        /* Stock Status */
        .item-stock {
            font-size: 14px;
            margin-bottom: 15px;
            margin-top: 15px;
        }
        .text-success {
            color: #4caf50;
        }
        .text-danger {
            color: #f44336;
        }

        /* Rating Stars */
        .item-rating {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .stars {
            display: flex;
            margin-right: 5px;
        }

        .stars i {
            color: #ddd;
            margin-right: 2px;
        }

        .stars i.filled {
            color: #ffc107;
        }

        .review-count {
            color: #777;
            font-size: 14px;
        }

        /* Action Buttons */
        .item-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-primary {
            background-color: #deaf33;
            border-color: #deaf33;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #c69c2c;
            border-color: #c69c2c;
        }

        .btn-outline-primary {
            border-color: #deaf33;
            color: #deaf33;
        }

        .btn-outline-primary:hover {
            background-color: #deaf33;
            color: #fff;
        }

        .view-details {
            flex-grow: 1;
        }

        /* Sale and Out of Stock Badges */
        .badge-container {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
        }

        .sale-badge {
            background-color: #e53935;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-badge {
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Pagination */
        .pagination-container {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .page-info {
            color: #777;
        }

        .page-link {
            color: #deaf33;
        }

        .page-item.active .page-link {
            background-color: #deaf33;
            border-color: #deaf33;
        }

        /* No Results */
        .empty-results {
            text-align: center;
            padding: 50px 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .empty-icon {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-results h3 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .empty-results a {
            color: #deaf33;
            text-decoration: none;
        }

        /* Active Filter Tags */
        .filter-tag {
            display: inline-block;
            background-color: #f0f0f0;
            border-radius: 30px;
            padding: 6px 12px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .remove-filter {
            margin-left: 5px;
            color: #999;
        }

        .remove-filter:hover {
            color: #e53935;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Quick view functionality can go here if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize any plugins or functionality needed for your product display
            const quickViewButtons = document.querySelectorAll('.quick-view');

            if (quickViewButtons.length > 0) {
                quickViewButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const productId = this.getAttribute('data-product-id');
                        // Implement quick view functionality here if needed
                        console.log('Quick view for product ID:', productId);
                    });
                });
            }
        });
    </script>
@endpush
