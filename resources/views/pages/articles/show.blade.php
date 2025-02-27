@extends('layouts.app')

@section('title', $article->meta_title ?? $article->title)

@section('meta_description', $article->meta_description ?? $article->excerpt)

@section('meta_tags')
    <meta property="og:title" content="{{ $article->meta_title ?? $article->title }}">
    <meta property="og:description" content="{{ $article->meta_description ?? $article->excerpt }}">
    @if($article->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $article->featured_image) }}">
    @endif
    <meta property="og:url" content="{{ route('articles.show', $article->slug) }}">
    <meta property="og:type" content="article">

    @if($article->keywords && is_array($article->keywords))
        <meta name="keywords" content="{{ implode(', ', $article->keywords) }}">
    @elseif($article->keywords)
        <meta name="keywords" content="{{ $article->keywords }}">
    @endif


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->meta_title ?? $article->title }}">
    <meta name="twitter:description" content="{{ $article->meta_description ?? $article->excerpt }}">
    @if($article->featured_image)
        <meta name="twitter:image" content="{{ asset('storage/' . $article->featured_image) }}">
    @endif
@endsection

@section('content')
    <!-- Article Header -->
    <div class="article-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    @if($article->category)
                        <div class="article-category wow fadeInUp">
                            <a href="{{ route('articles.by-category', $article->category->slug) }}">
                                {{ $article->category->name }}
                            </a>
                        </div>
                    @endif

                    <h1 class="article-title wow fadeInUp" data-wow-delay="0.1s">{{ $article->title }}</h1>

                    <div class="article-meta wow fadeInUp" data-wow-delay="0.2s">
                        <div class="meta-wrapper">
                            @if($article->author)
                                <div class="author-info">
                                    @if($article->author->profile_image)
                                        <img src="{{ asset('storage/' . $article->author->profile_image) }}" alt="{{ $article->author->name }}" class="author-image">
                                    @else
                                        <img src="https://via.placeholder.com/50x50" alt="{{ $article->author->name }}" class="author-image">
                                    @endif
                                    <span class="author-name">
                                        <a href="{{ route('articles.by-author', $article->author->slug) }}">
                                            {{ $article->author->name }}
                                        </a>
                                    </span>
                                </div>
                            @endif
                            <div class="article-info">
                                <span class="date"><i class="far fa-calendar-alt"></i> {{ $article->published_at->format('M d, Y') }}</span>
                                <span class="reading-time"><i class="far fa-clock"></i> {{ $article->reading_time }} min read</span>
                                <span class="views"><i class="far fa-eye"></i> {{ $article->view_count }} views</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Image -->
    <div class="article-featured-image wow fadeInUp" data-wow-delay="0.3s">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <figure>
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="img-fluid">
                        @else
                            <img src="https://via.placeholder.com/1200x600" alt="{{ $article->title }}" class="img-fluid">
                        @endif
                    </figure>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content & Sidebar -->
    <div class="article-main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Article Content -->
                    <div class="article-content wow fadeInUp" data-wow-delay="0.4s">
                        {!! $article->content !!}
                    </div>

                    <!-- Tags -->
                    @if($article->tags->isNotEmpty())
                        <div class="article-tags wow fadeInUp" data-wow-delay="0.5s">
                            <h5>Tags:</h5>
                            <div class="tag-cloud">
                                @foreach($article->tags as $tag)
                                    <a href="{{ route('articles.by-tag', $tag->slug) }}" class="tag-item">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="article-share wow fadeInUp" data-wow-delay="0.6s">
                        <h5>Share this article:</h5>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article->slug)) }}" target="_blank" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(route('articles.show', $article->slug)) }}" target="_blank" class="share-btn twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articles.show', $article->slug)) }}&title={{ urlencode($article->title) }}" target="_blank" class="share-btn linkedin">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                            <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode(route('articles.show', $article->slug)) }}" class="share-btn email">
                                <i class="far fa-envelope"></i> Email
                            </a>
                        </div>
                    </div>

                    <!-- Author Bio -->
                    @if($article->author)
                        <div class="author-bio wow fadeInUp" data-wow-delay="0.7s">
                            <div class="author-wrapper">
                                <div class="author-image-container">
                                    @if($article->author->profile_image)
                                        <img src="{{ asset('storage/' . $article->author->profile_image) }}" alt="{{ $article->author->name }}" class="author-large-image">
                                    @else
                                        <img src="https://via.placeholder.com/120x120" alt="{{ $article->author->name }}" class="author-large-image">
                                    @endif
                                </div>
                                <div class="author-details">
                                    <h5>About {{ $article->author->name }}</h5>
                                    <p>{{ $article->author->bio }}</p>


                                    @if($article->author->social_links && is_array($article->author->social_links))
                                        <div class="author-social">
                                            @foreach($article->author->social_links as $platform => $url)
                                                <a href="{{ $url }}" target="_blank" class="social-link">
                                                    <i class="fab fa-{{ strtolower($platform) }}"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="comments-section wow fadeInUp" data-wow-delay="0.8s">
                        <h3>Comments (0)</h3>
                        <div class="comment-form">
                            <form>
                                <div class="form-group">
                                    <label for="comment">Leave a comment</label>
                                    <textarea class="form-control" id="comment" rows="4" placeholder="Share your thoughts..."></textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" id="name" placeholder="Your name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="email" class="form-control" id="email" placeholder="Your email (will not be published)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="saveInfo">
                                        <label class="form-check-label" for="saveInfo">
                                            Save my name and email for the next time I comment
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn-submit">Submit Comment</button>
                            </form>
                        </div>
                    </div>

                    <!-- Related Articles -->
                    @if($relatedArticles->isNotEmpty())
                        <div class="related-articles wow fadeInUp" data-wow-delay="0.9s">
                            <h3>Related Articles</h3>
                            <div class="row">
                                @foreach($relatedArticles as $relatedArticle)
                                    <div class="col-md-4">
                                        <div class="related-article-item">
                                            <div class="post-featured-image">
                                                <a href="{{ route('articles.show', $relatedArticle->slug) }}" data-cursor-text="View">
                                                    <figure class="image-anime">
                                                        @if($relatedArticle->featured_image)
                                                            <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}" alt="{{ $relatedArticle->title }}">
                                                        @else
                                                            <img src="https://via.placeholder.com/300x200" alt="{{ $relatedArticle->title }}">
                                                        @endif
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="related-article-content">
                                                <h4><a href="{{ route('articles.show', $relatedArticle->slug) }}">{{ $relatedArticle->title }}</a></h4>
                                                <div class="related-article-meta">
                                                    <span>{{ $relatedArticle->published_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Popular Articles Widget -->
                    <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.5s">
                        <h4 class="widget-title">Popular Articles</h4>
                        <div class="popular-articles">
                            @foreach($popularArticles as $popularArticle)
                                @if($popularArticle->id != $article->id)
                                    <div class="popular-article-item">
                                        <div class="article-image">
                                            @if($popularArticle->featured_image)
                                                <a href="{{ route('articles.show', $popularArticle->slug) }}">
                                                    <img src="{{ asset('storage/' . $popularArticle->featured_image) }}" alt="{{ $popularArticle->title }}">
                                                </a>
                                            @else
                                                <a href="{{ route('articles.show', $popularArticle->slug) }}">
                                                    <img src="https://via.placeholder.com/100x100" alt="{{ $popularArticle->title }}">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="article-info">
                                            <h5><a href="{{ route('articles.show', $popularArticle->slug) }}">{{ $popularArticle->title }}</a></h5>
                                            <div class="meta">
                                                <span><i class="far fa-eye"></i> {{ $popularArticle->view_count }} views</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Articles Widget -->
                    <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.6s">
                        <h4 class="widget-title">Recent Articles</h4>
                        <div class="recent-articles">
                            @foreach($recentArticles as $recentArticle)
                                @if($recentArticle->id != $article->id)
                                    <div class="recent-article-item">
                                        <div class="article-image">
                                            @if($recentArticle->featured_image)
                                                <a href="{{ route('articles.show', $recentArticle->slug) }}">
                                                    <img src="{{ asset('storage/' . $recentArticle->featured_image) }}" alt="{{ $recentArticle->title }}">
                                                </a>
                                            @else
                                                <a href="{{ route('articles.show', $recentArticle->slug) }}">
                                                    <img src="https://via.placeholder.com/100x100" alt="{{ $recentArticle->title }}">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="article-info">
                                            <h5><a href="{{ route('articles.show', $recentArticle->slug) }}">{{ $recentArticle->title }}</a></h5>
                                            <div class="meta">
                                                <span>{{ $recentArticle->published_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.7s">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="category-list">
                            @foreach(App\Models\ArticleCategory::active()->get() as $category)
                                <li>
                                    <a href="{{ route('articles.by-category', $category->slug) }}" class="d-flex justify-content-between align-items-center">
                                        {{ $category->name }}
                                        <span class="count">{{ $category->getPublishedArticlesCount() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Newsletter Widget -->
                    <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.8s">
                        <h4 class="widget-title">Subscribe to Newsletter</h4>
                        <p>Stay updated with our latest articles and news.</p>
                        <form class="newsletter-form">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Your email address">
                            </div>
                            <button type="submit" class="btn-submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Header Styles */
        .article-header {
            padding: 5rem 0;
            background-color: #f8f9fa;
            margin-bottom: 0;
        }

        .article-category {
            margin-bottom: 1.5rem;
        }

        .article-category a {
            background-color: #deaf33;
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .article-category a:hover {
            background-color: #ff4f4f;
        }

        .article-title {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 2rem;
        }

        .article-meta {
            display: flex;
            justify-content: center;
        }

        .meta-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .author-info {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .author-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .author-name a {
            color: #333;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .author-name a:hover {
            color: #deaf33;
        }

        .article-info {
            color: #666;
            font-size: 0.9rem;
        }

        .article-info span {
            margin: 0 10px;
        }

        /* Featured Image */
        .article-featured-image {
            padding: 3rem 0;
            background-color: #fff;
        }

        .article-featured-image figure {
            margin: 0;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .article-featured-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Article Content */
        .article-main-content {
            padding: 5rem 0;
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
            margin-bottom: 3rem;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2 {
            font-size: 1.8rem;
            margin: 2.5rem 0 1rem;
            font-weight: 600;
        }

        .article-content h3 {
            font-size: 1.5rem;
            margin: 2rem 0 1rem;
            font-weight: 600;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            margin: 2rem 0;
            border-radius: 8px;
        }

        .article-content ul, .article-content ol {
            margin: 1.5rem 0;
            padding-left: 2rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .article-content blockquote {
            border-left: 4px solid #deaf33;
            padding: 1rem 0 1rem 2rem;
            margin: 2rem 0;
            font-style: italic;
            background-color: #f8f9fa;
        }

        /* Article Tags */
        .article-tags {
            margin-bottom: 3rem;
        }

        .article-tags h5 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: 600;
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

        /* Share Buttons */
        .article-share {
            margin-bottom: 3rem;
        }

        .article-share h5 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .share-buttons {
            display: flex;
            flex-wrap: wrap;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            margin: 0 10px 10px 0;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: opacity 0.3s ease;
        }

        .share-btn:hover {
            opacity: 0.9;
            color: #fff;
        }

        .share-btn i {
            margin-right: 8px;
        }

        .facebook {
            background-color: #3b5998;
        }

        .twitter {
            background-color: #1da1f2;
        }

        .linkedin {
            background-color: #0077b5;
        }

        .email {
            background-color: #555;
        }

        /* Author Bio */
        .author-bio {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .author-wrapper {
            display: flex;
            align-items: center;
        }

        .author-image-container {
            margin-right: 1.5rem;
        }

        .author-large-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-details h5 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .author-details p {
            color: #666;
            margin-bottom: 1rem;
        }

        .author-social {
            display: flex;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            background-color: #fff;
            color: #333;
            border-radius: 50%;
            margin-right: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: #deaf33;
            color: #fff;
        }

        /* Comments Section */
        .comments-section {
            margin-bottom: 3rem;
        }

        .comments-section h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .comment-form {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 2rem;
        }

        .comment-form label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .comment-form .form-control {
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 12px 15px;
        }

        .comment-form .form-check-label {
            font-size: 0.9rem;
            color: #666;
        }

        .btn-submit {
            background-color: #deaf33;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #ff4f4f;
        }

        /* Related Articles */
        .related-articles {
            margin-bottom: 3rem;
        }

        .related-articles h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .related-article-item {
            margin-bottom: 20px;
        }

        .related-article-item .post-featured-image {
            margin-bottom: 10px;
            overflow: hidden;
            border-radius: 8px;
        }

        .related-article-item .image-anime {
            margin: 0;
            overflow: hidden;
        }

        .related-article-item .image-anime img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .related-article-item:hover .image-anime img {
            transform: scale(1.1);
        }

        .related-article-content h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .related-article-content h4 a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .related-article-content h4 a:hover {
            color: #deaf33;
        }

        .related-article-meta {
            font-size: 0.85rem;
            color: #666;
        }

        /* Sidebar */
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
            font-weight: 600;
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

        /* Popular/Recent Articles Widget */
        .popular-article-item,
        .recent-article-item {
            display: flex;
            margin-bottom: 20px;
        }

        .popular-article-item:last-child,
        .recent-article-item:last-child {
            margin-bottom: 0;
        }

        .article-image {
            margin-right: 15px;
            flex-shrink: 0;
        }

        .article-image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .article-info h5 {
            font-size: 1rem;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .article-info h5 a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .article-info h5 a:hover {
            color: #deaf33;
        }

        .article-info .meta {
            font-size: 0.85rem;
            color: #666;
        }

        /* Categories Widget */
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        /* Newsletter Widget */
        .newsletter-form .form-control {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Animation */
        .wow {
            visibility: hidden;
        }

        /* Responsive Fixes */
        @media (max-width: 991px) {
            .article-title {
                font-size: 2.2rem;
            }

            .author-wrapper {
                flex-direction: column;
                text-align: center;
            }

            .author-image-container {
                margin-right: 0;
                margin-bottom: 1.5rem;
            }

            .author-social {
                justify-content: center;
            }
        }

        @media (max-width: 767px) {
            .article-header {
                padding: 3rem 0;
            }

            .article-title {
                font-size: 1.8rem;
            }

            .meta-wrapper {
                width: 100%;
            }

            .article-info {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .article-info span {
                margin: 5px 0;
            }

            .share-buttons {
                justify-content: center;
            }

            .related-articles .col-md-4 {
                margin-bottom: 20px;
            }

            .sidebar-widget {
                padding: 20px;
            }
        }
</style>
@endpush
