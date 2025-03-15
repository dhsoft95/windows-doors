@extends('layouts.app')

@section('content')
    <div class="page-products py-5">
        <div class="container-fluid px-4 px-md-5">
            <!-- Elegant Header Section with Animation -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeIn">Our Curated Collection</h1>
                    <p class="text-muted fs-5 mb-0 animate__animated animate__fadeIn animate__delay-1s">{{ $products->total() }} extraordinary pieces to explore</p>
                    <div class="separator mx-auto mt-4 animate__animated animate__fadeIn animate__delay-1s"></div>
                </div>
            </div>

            <!-- Enhanced Filter Panel -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="filter-container animate__animated animate__fadeInUp">
                        <form action="{{ route('products.index') }}" method="GET" class="filter-form">
                            <div class="row g-4 align-items-center">
                                <!-- Search Input -->
                                <div class="col-lg-5 col-md-6">
                                    <div class="search-wrapper">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" name="search" class="search-input"
                                               placeholder="Search our collection..."
                                               value="{{ request('search') }}">
                                        @if(request('search'))
                                            <button type="button" class="search-clear"
                                                    onclick="window.location.href='{{ request()->fullUrlWithoutQuery('search') }}'">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Category Filter with Enhanced Dropdown -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="select-wrapper">
                                        <select name="category" class="form-select custom-select">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>

                                <!-- Sort Options with Enhanced Dropdown -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="select-wrapper">
                                        <select name="sort" class="form-select custom-select">
                                            <option value="">Sort By</option>
                                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                                Price: Low to High
                                            </option>
                                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                                Price: High to Low
                                            </option>
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                                Newest First
                                            </option>
                                            <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>
                                                Popularity
                                            </option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>

                                <!-- Filter Button -->
                                <div class="col-lg-1 col-md-6">
                                    <button type="submit" class="btn filter-btn w-100">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Active Filters with Improved Styling -->
                            @if(request()->anyFilled(['search', 'category', 'sort']))
                                <div class="active-filters mt-4">
                                    @if(request('search'))
                                        <span class="filter-tag">
                                            <span class="filter-label">Search:</span> "{{ request('search') }}"
                                            <a href="{{ request()->fullUrlWithoutQuery('search') }}" class="remove-filter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if(request('category'))
                                        @php $selectedCategory = $categories->firstWhere('id', request('category')) @endphp
                                        <span class="filter-tag">
                                            <span class="filter-label">Category:</span> {{ $selectedCategory->name ?? '' }}
                                            <a href="{{ request()->fullUrlWithoutQuery('category') }}" class="remove-filter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if(request('sort'))
                                        <span class="filter-tag">
                                            <span class="filter-label">Sort:</span>
                                            @if(request('sort') == 'price_asc')
                                                Price: Low to High
                                            @elseif(request('sort') == 'price_desc')
                                                Price: High to Low
                                            @elseif(request('sort') == 'newest')
                                                Newest First
                                            @elseif(request('sort') == 'popularity')
                                                Popularity
                                            @endif
                                            <a href="{{ request()->fullUrlWithoutQuery('sort') }}" class="remove-filter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif

                                    <a href="{{ route('products.index') }}" class="clear-all-filters">
                                        Clear All Filters
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modern Gallery Grid with Animation -->
            <div class="row g-4">
                @forelse($products as $index => $product)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="gallery-item animate__animated animate__fadeIn" style="animation-delay: {{ 0.1 * $index }}s">
                            <div class="image-container">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img src="{{ asset('storage/' . $product->main_image) }}"
                                         alt="{{ $product->name }}"
                                         class="gallery-image"
                                         loading="lazy">

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

                                    <div class="hover-overlay">
                                        <div class="overlay-content">
                                            <span class="view-details">View Details</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="item-details">
                                <h3 class="item-title">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="item-description">
                                    {!! Str::limit(strip_tags($product->description), 120) !!}
                                </p>
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

                                @if($product->features->isNotEmpty())
                                    <div class="product-features">
                                        <h4 class="features-title">Features</h4>
                                        <ul class="features-list">
                                            @php $featureCount = 0; @endphp
                                            @foreach($product->features as $featureModel)
                                                @foreach($featureModel->features as $feature)
                                                    @if($featureCount < 3)
                                                        <li class="feature-item">
                                                            <i class="fas fa-check-circle feature-icon"></i>
                                                            {{ $feature }}
                                                        </li>
                                                        @php $featureCount++; @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach

                                            @if($featureCount >= 3)
                                                <li class="feature-more">
                                                    <a href="{{ route('products.show', $product->slug) }}">+ More features</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                <div class="item-actions">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-view-product">
                                        View Product
                                    </a>
                                    @if($product->is_in_stock)
                                        <button class="action-btn quick-view"
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
                        <div class="empty-results animate__animated animate__fadeIn">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>No Items Found</h3>
                            <p>We couldn't find any items matching your criteria. Try adjusting your filters or <a href="{{ route('products.index') }}">view all items</a>.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Clean Pagination with Improved Styling -->
            @if($products->total() > 0)
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="pagination-container animate__animated animate__fadeIn">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="page-info mb-3 mb-md-0">
                                    Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}
                                </div>
                                {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickViewModalLabel">Product Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="quick-view-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="quick-view-image-container">
                                    <img id="quickViewImage" src="" alt="Product Image" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="quick-view-details">
                                    <h2 id="quickViewTitle"></h2>
                                    <div class="quick-view-rating mb-3">
                                        <div id="quickViewStars" class="stars"></div>
                                        <span id="quickViewReviewCount" class="review-count"></span>
                                    </div>
                                    <div id="quickViewDescription" class="mb-4"></div>
                                    <div id="quickViewFeatures" class="mb-4"></div>
                                    <div class="quick-view-actions">
                                        <a id="quickViewDetailsLink" href="#" class="btn-view-details">View Full Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Base Styles */
        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Section */
        .display-4 {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .separator {
            height: 4px;
            width: 60px;
            background: linear-gradient(90deg, #deaf33, #f9d56e);
            border-radius: 2px;
            margin-top: 20px;
        }

        /* Filter Styles */
        .filter-container {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .search-wrapper {
            position: relative;
            width: 100%;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .search-input {
            width: 100%;
            height: 54px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 0 45px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .search-input:focus {
            border-color: #deaf33;
            outline: none;
            box-shadow: 0 0 0 3px rgba(222, 175, 51, 0.1);
        }

        .search-clear {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: 16px;
        }

        .search-clear:hover {
            color: #ff4545;
        }

        /* Select Styling */
        .select-wrapper {
            position: relative;
        }

        .select-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        .custom-select {
            height: 54px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            padding: 0 20px;
            font-size: 16px;
            background-color: #fff;
            transition: all 0.3s;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .custom-select:focus {
            border-color: #deaf33;
            outline: none;
            box-shadow: 0 0 0 3px rgba(222, 175, 51, 0.1);
        }

        .filter-btn {
            height: 54px;
            border-radius: 12px;
            background-color: #deaf33;
            color: #fff;
            border: none;
            font-size: 18px;
            transition: all 0.3s;
        }

        .filter-btn:hover {
            background-color: #c79b23;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(222, 175, 51, 0.2);
        }

        .filter-tag {
            display: inline-block;
            padding: 8px 16px;
            background-color: #f5f5f5;
            border-radius: 30px;
            font-size: 14px;
            color: #333;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }

        .filter-tag:hover {
            background-color: #eaeaea;
        }

        .filter-label {
            font-weight: 600;
            color: #666;
        }

        .remove-filter {
            color: #999;
            margin-left: 8px;
            transition: color 0.2s;
        }

        .remove-filter:hover {
            color: #ff4545;
        }

        .clear-all-filters {
            display: inline-block;
            padding: 8px 16px;
            color: #ff4545;
            font-size: 14px;
            font-weight: 600;
            margin-left: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .clear-all-filters:hover {
            text-decoration: underline;
        }

        /* Gallery Item Styles */
        .gallery-item {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .image-container {
            position: relative;
            overflow: hidden;
            padding-top: 75%; /* 4:3 Aspect Ratio */
            background-color: #f5f5f5;
        }

        .gallery-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.08);
        }

        .hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            opacity: 0;
            transition: opacity 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-item:hover .hover-overlay {
            opacity: 1;
        }

        .overlay-content {
            text-align: center;
        }

        .view-details {
            display: inline-block;
            padding: 12px 24px;
            background: #fff;
            color: #333;
            font-weight: 600;
            border-radius: 30px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease 0.1s;
        }

        .gallery-item:hover .view-details {
            transform: translateY(0);
            opacity: 1;
        }

        .badge-container {
            position: absolute;
            z-index: 2;
        }

        .badge-container.sale {
            top: 16px;
            right: 16px;
        }

        .badge-container.stock {
            top: 16px;
            left: 16px;
        }

        .sale-badge {
            background: linear-gradient(135deg, #deaf33, #f9d56e);
            color: #fff;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            box-shadow: 0 4px 12px rgba(222, 175, 51, 0.2);
        }

        .stock-badge {
            background: #333;
            color: #fff;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .item-details {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .item-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .item-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
        }

        .item-title a:hover {
            color: #deaf33;
        }

        .item-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-rating {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .stars {
            display: flex;
            margin-right: 8px;
        }

        .stars .fa-star {
            color: #e0e0e0;
            margin-right: 3px;
            font-size: 15px;
        }

        .stars .fa-star.filled {
            color: #deaf33;
        }

        .review-count {
            color: #999;
            font-size: 14px;
        }

        /* Features styling */
        .product-features {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .features-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #555;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-item {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
        }

        .feature-icon {
            color: #deaf33;
            margin-right: 8px;
            font-size: 14px;
            margin-top: 2px;
        }

        .feature-more {
            font-size: 13px;
            margin-top: 5px;
            list-style: none;
        }

        .feature-more a {
            color: #deaf33;
            text-decoration: none;
            font-weight: 600;
        }

        .feature-more a:hover {
            text-decoration: underline;
        }

        .item-actions {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-view-product {
            padding: 10px 20px;
            background: linear-gradient(135deg, #deaf33, #f9d56e);
            color: #fff;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
            flex-grow: 1;
            text-align: center;
            margin-right: 10px;
        }

        .btn-view-product:hover {
            background: linear-gradient(135deg, #c79b23, #deaf33);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(222, 175, 51, 0.2);
            color: #fff;
        }

        .action-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #f5f5f5;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            font-size: 16px;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .action-btn:hover {
            background: #deaf33;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(222, 175, 51, 0.2);
        }

        /* Empty Results Styles */
        .empty-results {
            text-align: center;
            padding: 80px 20px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .empty-icon {
            font-size: 50px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .empty-results h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .empty-results p {
            color: #777;
            max-width: 500px;
            margin: 0 auto;
        }

        .empty-results a {
            color: #deaf33;
            text-decoration: none;
            font-weight: 600;
        }

        /* Pagination Styles */
        .pagination-container {
            background: #fff;
            border-radius: 16px;
            padding: a20px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .page-info {
            color: #777;
            font-size: 15px;
        }

        .pagination {
            margin: 0;
        }

        .pagination .page-item .page-link {
            border: none;
            color: #333;
            font-weight: 500;
            padding: 8px 16px;
            margin: 0 5px;
            border-radius: 8px;
            background: #f5f5f5;
            transition: all 0.3s;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #deaf33, #f9d56e);
            color: #fff;
        }

        .pagination .page-item .page-link:hover {
            background: #eaeaea;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link:hover {
            background: linear-gradient(135deg, #c79b23, #deaf33);
        }

        /* Quick View Modal Styles */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        }

        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px 30px;
        }

        .modal-title {
            font-weight: 600;
            color: #333;
        }

        .modal-body {
            padding: 30px;
        }

        .quick-view-image-container {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
            border-radius: 12px;
            overflow: hidden;
        }

        .quick-view-image-container img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .quick-view-details {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .quick-view-details h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .quick-view-rating {
            display: flex;
            align-items: center;
        }

        .btn-view-details {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #deaf33, #f9d56e);
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-view-details:hover {
            background: linear-gradient(135deg, #c79b23, #deaf33);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(222, 175, 51, 0.2);
            color: #fff;
        }

        /* Responsive Adjustments */
        @media (max-width: 1199px) {
            .image-container {
                padding-top: 80%; /* Slightly taller on medium screens */
            }
        }

        @media (max-width: 991px) {
            .container-fluid {
                padding: 0 15px;
            }

            .filter-container {
                padding: 20px;
            }

            .gallery-item {
                margin-bottom: 0;  /* Grid already provides spacing */
            }

            .item-title {
                font-size: 16px;
            }

            .item-details {
                padding: 20px;
            }
        }

        @media (max-width: 767px) {
            .search-input, .custom-select, .filter-btn {
                height: 50px;
            }

            .image-container {
                padding-top: 70%; /* Shorter images on mobile */
            }

            .btn-view-product {
                padding: 8px 15px;
                font-size: 13px;
            }

            .action-btn {
                width: 38px;
                height: 38px;
            }

            .pagination-container {
                padding: 15px;
            }

            .page-info {
                margin-bottom: 10px;
            }
        }

        /* Animation for items when they appear */
        @keyframes itemAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading Skeleton Styles */
        .skeleton-loader {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 4px;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if required libraries are loaded
            const hasBoostrap = typeof bootstrap !== 'undefined';

            // Quick view handler
            const quickViewBtns = document.querySelectorAll('.quick-view');
            let quickViewModal;

            if (hasBoostrap) {
                quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            }

            quickViewBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productId = this.getAttribute('data-product-id');

                    // Show loading state
                    document.getElementById('quickViewTitle').innerHTML = '<div class="skeleton-loader" style="height: 28px; width: 70%;"></div>';
                    document.getElementById('quickViewDescription').innerHTML = '<div class="skeleton-loader" style="height: 80px; width: 100%;"></div>';
                    document.getElementById('quickViewImage').src = '/path/to/placeholder.jpg';

                    if (hasBoostrap) {
                        quickViewModal.show();
                    }

                    // Fetch product details with AJAX
                    fetchProductDetails(productId);
                });
            });

            // Simulate product details fetching (replace with actual AJAX call)
            function fetchProductDetails(productId) {
                // In a real implementation, you would make an AJAX call to your backend
                // For example:
                // fetch('/api/products/' + productId)
                //     .then(response => response.json())
                //     .then(data => updateQuickViewModal(data));

                // For demonstration, we'll simulate a delay
                setTimeout(() => {
                    // Find the product in the DOM to extract its data
                    const productElement = document.querySelector(`.quick-view[data-product-id="${productId}"]`).closest('.gallery-item');

                    if (productElement) {
                        // Extract data from the DOM element
                        const imgSrc = productElement.querySelector('.gallery-image').src;
                        const title = productElement.querySelector('.item-title a').textContent.trim();
                        const description = productElement.querySelector('.item-description').innerHTML;
                        const link = productElement.querySelector('.item-title a').getAttribute('href');

                        // Generate stars HTML if rating exists
                        let starsHtml = '';
                        const starsElement = productElement.querySelector('.stars');
                        if (starsElement) {
                            starsHtml = starsElement.innerHTML;
                        }

                        // Update modal content
                        document.getElementById('quickViewImage').src = imgSrc;
                        document.getElementById('quickViewTitle').textContent = title;
                        document.getElementById('quickViewDescription').innerHTML = description;
                        document.getElementById('quickViewStars').innerHTML = starsHtml;
                        document.getElementById('quickViewDetailsLink').href = link;

                        // If there are features, add them
                        const featuresElement = productElement.querySelector('.product-features');
                        if (featuresElement) {
                            document.getElementById('quickViewFeatures').innerHTML = featuresElement.innerHTML;
                        } else {
                            document.getElementById('quickViewFeatures').innerHTML = '';
                        }
                    }
                }, 500); // Simulate network delay
            }

            // Image lazy loading with animation
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                delete img.dataset.src;
                            }
                            img.classList.add('fade-in');
                            observer.unobserve(img);
                        }
                    });
                }, {
                    rootMargin: '50px 0px',
                    threshold: 0.1
                });

                const lazyImages = document.querySelectorAll('.gallery-image');
                lazyImages.forEach(img => {
                    imageObserver.observe(img);
                });
            }

            // Enhanced select behavior
            const selects = document.querySelectorAll('.custom-select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value) {
                        this.style.fontWeight = '500';
                        this.style.color = '#333';
                    } else {
                        this.style.fontWeight = 'normal';
                        this.style.color = '#666';
                    }
                });

                // Set initial state
                if (select.value) {
                    select.style.fontWeight = '500';
                    select.style.color = '#333';
                }
            });
        });
    </script>
@endpush
