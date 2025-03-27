@extends('layouts.app')

@section('content')
    <div class="page-categories py-5">
        <div class="container-fluid px-4 px-md-5">
            <!-- Header Section -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-4">Product Categories</h1>
                    <p class="text-muted fs-5 mb-0">Browse our collection by category</p>
                    <div class="separator mx-auto mt-4"></div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="row g-5">
                @forelse($categories as $category)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="category-card">
                            <a href="{{ route('categories.show', $category->slug) }}" class="category-link">
                                <div class="category-image-container">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
                                    @else
                                        <div class="category-placeholder">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                    @endif
                                    <div class="category-overlay">
                                        <span class="browse-label">Browse Category</span>
                                    </div>
                                </div>

                                <div class="category-info">
                                    <h3 class="category-title">{{ $category->name }}</h3>
                                    <p class="category-count">{{ $category->products_count }} Products</p>

                                    @if($category->description)
                                        <div class="category-description">{!! $category->description !!}</div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-results">
                            <div class="empty-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3>No Categories Found</h3>
                            <p>There are currently no product categories available.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Category card styles */
        .category-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .category-link {
            display: block;
            height: 100%;
            color: inherit;
            text-decoration: none;
        }

        .category-image-container {
            position: relative;
            overflow: hidden;
            padding-top: 65%; /* Aspect ratio */
            background-color: #f5f5f5;
        }

        .category-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .category-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #ccc;
        }

        .category-card:hover .category-image {
            transform: scale(1.08);
        }

        .category-overlay {
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

        .category-card:hover .category-overlay {
            opacity: 1;
        }

        .browse-label {
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

        .category-card:hover .browse-label {
            transform: translateY(0);
            opacity: 1;
        }

        .category-info {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .category-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .category-count {
            color: #deaf33;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .category-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 0;
            max-height: 150px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #ccc #f5f5f5;
        }

        /* For Webkit browsers (Chrome, Safari) */
        .category-description::-webkit-scrollbar {
            width: 6px;
        }

        .category-description::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        .category-description::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 6px;
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

        /* Separator */
        .separator {
            width: 60px;
            height: 4px;
            background-color: #deaf33;
            border-radius: 2px;
        }
    </style>
@endpush
