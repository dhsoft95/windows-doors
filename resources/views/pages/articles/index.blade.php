@extends('layouts.app')

@section('title', isset($currentCategory) ? $currentCategory->name : (isset($currentTag) ? 'Articles tagged with: ' . $currentTag->name : (isset($currentAuthor) ? 'Articles by: ' . $currentAuthor->name : 'All Articles')))

@section('meta_description')
    @if(isset($currentCategory))
        {{ $currentCategory->meta_description ?? 'Browse all articles in ' . $currentCategory->name . ' category.' }}
    @elseif(isset($currentTag))
        {{ 'Browse all articles tagged with ' . $currentTag->name }}
    @elseif(isset($currentAuthor))
        {{ 'Browse all articles written by ' . $currentAuthor->name }}
    @else
        Browse all our articles on various topics.
    @endif
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    @if(isset($currentCategory))
                        <h1>{{ $currentCategory->name }}</h1>
                        <p class="lead">{{ $currentCategory->description }}</p>
                    @elseif(isset($currentTag))
                        <h1>Articles tagged with: {{ $currentTag->name }}</h1>
                    @elseif(isset($currentAuthor))
                        <h1>Articles by: {{ $currentAuthor->name }}</h1>
                        @if($currentAuthor->bio)
                            <p class="lead">{{ $currentAuthor->bio }}</p>
                        @endif
                    @else
                        <h1>Latest Articles</h1>
                        <p class="lead">Stay updated with our latest insights and news</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <div class="page-blog">
        <div class="container">
            <div class="row">
                <!-- Featured Articles Section (only show on main page) -->
                @if(!isset($currentCategory) && !isset($currentTag) && !isset($currentAuthor) && $featuredArticles->isNotEmpty())
                    @foreach($featuredArticles as $featuredArticle)
                        <div class="col-lg-4 col-md-6">
                            <!-- Post Item Start -->
                            <div class="post-item wow fadeInUp" data-wow-delay="0.{{ $loop->index * 2 }}s">
                                <!-- Post Featured Image Start-->
                                <div class="post-featured-image">
                                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" data-cursor-text="View">
                                        <figure class="image-anime">
                                            @if($featuredArticle->featured_image)
                                                <img src="{{ asset('storage/' . $featuredArticle->featured_image) }}" alt="{{ $featuredArticle->title }}">
                                            @else
                                                <img src="https://via.placeholder.com/600x400" alt="{{ $featuredArticle->title }}">
                                            @endif
                                        </figure>
                                    </a>
                                    <span class="featured-badge">Featured</span>
                                </div>
                                <!-- Post Featured Image End -->

                                <!-- post Item Body Start -->
                                <div class="post-item-body">
                                    <!-- Post Item Content Start -->
                                    <div class="post-item-content">
                                        <h2><a href="{{ route('articles.show', $featuredArticle->slug) }}">{{ $featuredArticle->title }}</a></h2>
                                        <p>{{ $featuredArticle->excerpt }}</p>

                                        <div class="post-meta">
                                            @if($featuredArticle->category)
                                                <span class="category">
                                                    <a href="{{ route('articles.by-category', $featuredArticle->category->slug) }}">
                                                        {{ $featuredArticle->category->name }}
                                                    </a>
                                                </span>
                                            @endif
                                            <span class="date">{{ $featuredArticle->published_at->format('M d, Y') }}</span>
                                            <span class="reading-time"><i class="far fa-clock"></i> {{ $featuredArticle->reading_time }} min read</span>
                                        </div>
                                    </div>
                                    <!-- Post Item Content End-->

                                    <!-- Post Item Button Start-->
                                    <div class="post-item-btn">
                                        <a href="{{ route('articles.show', $featuredArticle->slug) }}">Read more</a>
                                    </div>
                                    <!-- Post Item Button End-->
                                </div>
                                <!-- post Item Body End -->
                            </div>
                            <!-- Post Item End -->
                        </div>
                    @endforeach
                @endif

                <!-- Main Articles -->
                @if($articles->isEmpty())
                    <div class="col-lg-12">
                        <div class="alert alert-info">
                            No articles found. Please check back later.
                        </div>
                    </div>
                @else
                    @foreach($articles as $article)
                        <div class="col-lg-4 col-md-6">
                            <!-- Post Item Start -->
                            <div class="post-item wow fadeInUp" data-wow-delay="0.{{ $loop->index * 2 }}s">
                                <!-- Post Featured Image Start-->
                                <div class="post-featured-image">
                                    <a href="{{ route('articles.show', $article->slug) }}" data-cursor-text="View">
                                        <figure class="image-anime">
                                            @if($article->featured_image)
                                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                                            @else
                                                <img src="https://via.placeholder.com/600x400" alt="{{ $article->title }}">
                                            @endif
                                        </figure>
                                    </a>
                                </div>
                                <!-- Post Featured Image End -->

                                <!-- post Item Body Start -->
                                <div class="post-item-body">
                                    <!-- Post Item Content Start -->
                                    <div class="post-item-content">
                                        <h2><a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a></h2>
                                        <p>{{ $article->excerpt }}</p>

                                        <div class="post-meta">
                                            @if($article->category)
                                                <span class="category">
                                                    <a href="{{ route('articles.by-category', $article->category->slug) }}">
                                                        {{ $article->category->name }}
                                                    </a>
                                                </span>
                                            @endif
                                            <span class="date">{{ $article->published_at->format('M d, Y') }}</span>
                                            <span class="reading-time"><i class="far fa-clock"></i> {{ $article->reading_time }} min read</span>
                                        </div>
                                    </div>
                                    <!-- Post Item Content End-->

                                    <!-- Post Item Button Start-->
                                    <div class="post-item-btn">
                                        <a href="{{ route('articles.show', $article->slug) }}">Read more</a>
                                    </div>
                                    <!-- Post Item Button End-->
                                </div>
                                <!-- post Item Body End -->
                            </div>
                            <!-- Post Item End -->
                        </div>
                    @endforeach

                    <div class="col-lg-12">
                        <!-- Page Pagination Start -->
                        <div class="page-pagination wow fadeInUp" data-wow-delay="0.4s">
                            {{ $articles->withQueryString()->links() }}
                        </div>
                        <!-- Page Pagination End -->
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Section -->
    <section class="sidebar-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Categories Widget -->
                <div class="col-lg-4 col-md-6">
                    <div class="sidebar-widget wow fadeInUp">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="category-list">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('articles.by-category', $category->slug) }}" class="d-flex justify-content-between align-items-center">
                                        {{ $category->name }}
                                        <span class="count">{{ $category->getPublishedArticlesCount() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Popular Tags Widget -->
                <div class="col-lg-4 col-md-6">
                    <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.2s">
                        <h4 class="widget-title">Popular Tags</h4>
                        <div class="tag-cloud">
                            @foreach(App\Models\Tag::withCount('articles')->orderBy('articles_count', 'desc')->limit(15)->get() as $tag)
                                <a href="{{ route('articles.by-tag', $tag->slug) }}" class="tag-item">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Newsletter Widget -->
                <div class="col-lg-4 col-md-12">
                    <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.4s">
                        <h4 class="widget-title">Subscribe to Newsletter</h4>
                        <p>Stay updated with our latest articles and news.</p>
                        <form class="newsletter-form">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Your email address">
                            </div>
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Hero Section */
        .hero-section {
            background-color: #f8f9fa;
            padding: 4rem 0;
            margin-bottom: 0;
        }

        /* Blog Items */
        .page-blog {
            padding: 5rem 0;
        }

        .post-item {
            margin-bottom: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .post-featured-image {
            position: relative;
            overflow: hidden;
        }

        .image-anime {
            margin: 0;
            overflow: hidden;
        }

        .image-anime img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .post-item:hover .image-anime img {
            transform: scale(1.1);
        }

        .featured-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #deaf33;
            color: #fff;
            padding: 0.25rem 0.75rem;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 2;
        }

        .post-item-body {
            padding: 25px;
            background: #fff;
        }

        .post-item-content h2 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            font-weight: 600;
            line-height: 1.3;
        }

        .post-item-content h2 a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .post-item-content h2 a:hover {
            color: #deaf33;
        }

        .post-item-content p {
            color: #666;
            margin-bottom: 20px;
        }

        .post-meta {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
            font-size: 0.85rem;
            color: #777;
        }

        .post-meta span {
            margin-right: 15px;
        }

        .post-meta .category a {
            color: #deaf33;
            font-weight: 600;
        }

        .post-item-btn {
            margin-top: 20px;
        }

        .post-item-btn a {
            display: inline-block;
            position: relative;
            color: #333;
            font-weight: 600;
            text-decoration: none;
            padding-bottom: 5px;
            transition: color 0.3s ease;
        }

        .post-item-btn a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #deaf33;
            transition: width 0.3s ease;
        }

        .post-item-btn a:hover {
            color: #deaf33;
        }

        .post-item-btn a:hover:after {
            width: 100%;
        }

        /* Pagination */
        .page-pagination {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .pagination li.active a,
        .pagination li.active span {
            background: #deaf33;
            color: #fff;
        }

        .pagination li a:hover {
            background: #deaf33;
            color: #fff;
        }

        /* Sidebar */
        .sidebar-section {
            padding: 5rem 0;
        }

        .sidebar-widget {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .widget-title {
            font-size: 1.4rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .widget-title:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 2px;
            background: #deaf33;
            bottom: 0;
            left: 0;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-list li a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .category-list li a:hover {
            color: #deaf33;
        }

        .category-list .count {
            background: #f5f5f5;
            color: #666;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .tag-cloud {
            display: flex;
            flex-wrap: wrap;
        }

        .tag-item {
            background: #f5f5f5;
            color: #666;
            padding: 5px 15px;
            border-radius: 20px;
            margin: 0 8px 8px 0;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .tag-item:hover {
            background: #deaf33;
            color: #fff;
        }

        .newsletter-form .form-control {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .newsletter-form .btn {
            padding: 10px 25px;
            border-radius: 5px;
            background: #deaf33;
            border: none;
            transition: background 0.3s ease;
        }

        .newsletter-form .btn:hover {
            background: #ff4f4f;
        }

        /* Animation */
        .wow {
            visibility: hidden;
        }

        /* Make sure we style Laravel's pagination */
        .page-pagination .pagination .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin: 0 5px;
        }

        .page-pagination .pagination .page-item.active .page-link {
            background: #deaf33;
            color: #fff;
        }

        .page-pagination .pagination .page-item .page-link:hover {
            background: #deaf33;
            color: #fff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
@endpush
