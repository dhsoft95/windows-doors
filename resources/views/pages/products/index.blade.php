@extends('layouts.app')

@section('content')
    <div class="page-products py-5">
        <div class="container-fluid px-4 px-md-5">
            <!-- Elegant Header Section -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-4">Our Curated Collection</h1>
                    <p class="text-muted fs-5 mb-0">{{ $products->total() }} extraordinary pieces to explore</p>
                    <div class="separator mx-auto mt-4"></div>
                </div>
            </div>

            <!-- Minimal Filter Panel -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="filter-container">
                        <form action="{{ route('products.index') }}" method="GET" class="filter-form">
                            <div class="row g-4 align-items-center">
                                <!-- Search Input -->
                                <div class="col-lg-5 col-md-6">
                                    <div class="search-wrapper">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" name="search" class="search-input"
                                               placeholder="Search our collection..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>

                                <!-- Category Filter -->
                                <div class="col-lg-3 col-md-6">
                                    <select name="category" class="form-select custom-select">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sort Options -->
                                <div class="col-lg-3 col-md-6">
                                    <select name="sort" class="form-select custom-select">
                                        <option value="">Sort By</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            Price: Low to High
                                        </option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            Price: High to Low
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter Button -->
                                <div class="col-lg-1 col-md-6">
                                    <button type="submit" class="btn filter-btn w-100">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Active Filters -->
                            @if(request()->anyFilled(['search', 'category', 'sort']))
                                <div class="active-filters mt-4">
                                    @if(request('search'))
                                        <span class="filter-tag">
                                            Search: "{{ request('search') }}"
                                            <a href="{{ request()->fullUrlWithoutQuery('search') }}" class="remove-filter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if(request('category'))
                                        @php $selectedCategory = $categories->firstWhere('id', request('category')) @endphp
                                        <span class="filter-tag">
                                            Category: {{ $selectedCategory->name ?? '' }}
                                            <a href="{{ request()->fullUrlWithoutQuery('category') }}" class="remove-filter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if(request('sort'))
                                        <span class="filter-tag">
                                            Sort: {{ request('sort') == 'price_asc' ? 'Low to High' : 'High to Low' }}
                                            <a href="{{ request()->fullUrlWithoutQuery('sort') }}" class="remove-filter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modern Gallery Grid -->
            <div class="row g-5">
                @forelse($products as $product)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="gallery-item">
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
                                            @foreach($product->features as $featureModel)
                                                @foreach($featureModel->features as $feature)
                                                    <li class="feature-item">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        {{ $feature }}
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="item-actions">
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
                        <div class="empty-results">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>No Items Found</h3>
                            <p>We couldn't find any items matching your criteria. Try adjusting your filters or <a href="{{ route('products.index') }}">view all items</a>.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Clean Pagination -->
            @if($products->total() > 0)
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="pagination-container">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="page-info">
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
@endsection

@push('styles')
    <style>
        /* Base Styles */
        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Header Section */
        .display-4 {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .separator {
            height: 4px;
            width: 60px;
            background: #deaf33;
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
            padding: 0 20px 0 45px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .search-input:focus {
            border-color: #deaf33;
            outline: none;
            box-shadow: 0 0 0 3px rgba(222, 175, 51, 0.1);
        }

        .custom-select {
            height: 54px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            padding: 0 20px;
            font-size: 16px;
            background-color: #fff;
            transition: all 0.3s;
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
        }

        .remove-filter {
            color: #999;
            margin-left: 8px;
            transition: color 0.2s;
        }

        .remove-filter:hover {
            color: #ff4545;
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
            padding-top: 100%; /* 1:1 Aspect Ratio */
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
            background: #deaf33;
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

        .item-features {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .feature {
            display: inline-block;
            padding: 6px 12px;
            background: #f8f8f8;
            border-radius: 8px;
            font-size: 13px;
            color: #666;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .feature i {
            color: #4CAF50;
            margin-right: 4px;
        }

        .item-actions {
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
        }

        .action-btn {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #f5f5f5;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            color: #555;
            font-size: 18px;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: #deaf33;
            color: #fff;
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
            padding: 20px 30px;
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
        }

        .pagination .page-item.active .page-link {
            background: #deaf33;
            color: #fff;
        }

        .pagination .page-item .page-link:hover {
            background: #eaeaea;
        }

        .pagination .page-item.active .page-link:hover {
            background: #c79b23;
        }

        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .gallery-item {
                margin-bottom: 30px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quick view handler
            document.querySelectorAll('.quick-view').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productId = this.getAttribute('data-product-id');
                    console.log('Quick view for product:', productId);

                    // Here you would implement the modal loading logic
                    // Example: fetchProductDetails(productId).then(data => showQuickViewModal(data));
                });
            });

            // Optional: Image lazy loading with animation
            const lazyImages = document.querySelectorAll('.gallery-image');

            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.classList.add('fade-in');
                            observer.unobserve(img);
                        }
                    });
                }, {
                    rootMargin: '50px'
                });

                lazyImages.forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
@endpush
