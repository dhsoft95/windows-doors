@extends('layouts.app')

@section('content')
    <div class="page-product-detail">
        <div class="container">
            <!-- Main Product Section -->
            <div class="product-main-section">
                <div class="row">
                    <!-- Feature Icons Column -->
                    <div class="col-md-2 col-sm-12">
                        <div class="feature-icons-container">
                            <div class="feature-icon-item">
                                <div class="feature-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="feature-label">
                                    Israel/European<br>standard
                                </div>
                            </div>

                            <div class="feature-icon-item">
                                <div class="feature-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="feature-label">
                                    Self-destruct<br>mechanism
                                </div>
                            </div>

                            <div class="feature-icon-item">
                                <div class="feature-icon">
                                    <i class="fas fa-volume-off"></i>
                                </div>
                                <div class="feature-label">
                                    Thermal<br>and acoustic<br>insulation
                                </div>
                            </div>

                            <div class="feature-icon-item">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="feature-label">
                                    Strong<br>resistant door
                                </div>
                            </div>

                            <div class="feature-icon-item">
                                <div class="feature-icon">
                                    <span class="depth-number">25</span>
                                </div>
                                <div class="feature-label">
                                    High safety lock<br>25mm depth
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Product Image -->
                    <div class="col-md-5 col-sm-12">
                        <div class="product-image-main">
                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid">
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-5 col-sm-12">
                        <div class="product-info-container">
                            <h1 class="product-model-title">
                                {{ $product->model_number ?? 'SL 7050' }} – {{ $product->style_code ?? 'WINDOW ' . $product->id }}
                            </h1>

                            <div class="product-description mt-4">
                                {!! Purifier::clean($product->description) !!}
                            </div>

                            <!-- Product Specifications -->
                            @if($product->specifications->count() > 0)
                                <div class="product-specs mt-4">
                                    <h3 class="specs-title">Specifications</h3>
                                    <div class="specs-list">
                                        @foreach($product->specifications as $spec)
                                            <div class="spec-item">
                                                <span class="spec-label">{{ $spec->label }}:</span>
                                                <span class="spec-value">{{ $spec->value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Product Features -->
                            @if($product->features->count() > 0)
                                <div class="product-features mt-4">
                                    <h3 class="features-title">Features</h3>
                                    <ul class="features-list">
                                        @foreach($product->features->flatMap->features as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Contact Button -->
                            <div class="contact-section mt-5">
                                <a href="{{ route('contact') }}" class="btn btn-primary btn-contact">
                                    Contact for Inquiry
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Similar Products Section -->
            <div class="similar-products-section mt-5 pt-5">
                <h2 class="section-title text-center mb-5">SIMILAR PRODUCTS</h2>

                <div class="row">
                    @if($product->relatedProducts->count() > 0)
                        @foreach($product->relatedProducts as $relatedProduct)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" class="similar-product-item">
                                    <div class="product-image">
                                        <img src="{{ asset('storage/' . $relatedProduct->main_image) }}"
                                             alt="{{ $relatedProduct->name }}"
                                             class="img-fluid">
                                    </div>
                                    <div class="product-title text-center mt-3">
                                        {{ $relatedProduct->model_number ?? 'SL 7050' }} – {{ $relatedProduct->style_code ?? 'WINDOW ' . $relatedProduct->id }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <p>No similar products found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Page Container */
        .page-product-detail {
            padding: 60px 0;
            background-color: #fff;
        }

        /* Main Product Section */
        .product-main-section {
            margin-bottom: 60px;
            padding-bottom: 40px;
            border-bottom: 1px solid #e1e1e1;
        }

        /* Feature Icons */
        .feature-icons-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feature-icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .feature-icon i {
            font-size: 32px;
            color: #deaf33;
        }

        .depth-number {
            font-size: 32px;
            font-weight: bold;
            color: #deaf33;
        }

        .feature-label {
            font-size: 12px;
            line-height: 1.3;
            color: #555;
        }

        /* Main Product Image */
        .product-image-main {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            padding: 0;
            height: auto;
            min-height: 400px;
        }

        .product-image-main img {
            max-width: 100%;
            max-height: 600px;
            object-fit: contain;
            display: block;
        }

        /* Product Info */
        .product-info-container {
            padding: 20px 0;
        }

        .product-model-title {
            font-size: 35px;
            font-weight: 600;
            color: #1e1e1e;
            margin-bottom: 30px;
        }

        .product-description {
            font-size: 15px;
            line-height: 1.6;
            color: #555;
        }

        /* Specifications */
        .specs-title, .features-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1e1e1e;
        }

        .specs-list {
            border-top: 1px solid #eee;
        }

        .spec-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .spec-label {
            width: 40%;
            font-weight: 500;
            color: #555;
        }

        .spec-value {
            width: 60%;
            color: #1e1e1e;
        }

        /* Features List */
        .features-list {
            padding-left: 20px;
        }

        .features-list li {
            margin-bottom: 8px;
            color: #555;
        }

        /* Contact Button */
        .btn-contact {
            background-color: #deaf33;
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
            color: #1e1e1e;
        }

        .btn-contact:hover {
            background-color: #c79b23;
            transform: translateY(-2px);
            color: #1e1e1e;
        }

        /* Similar Products Section */
        .section-title {
            font-size: 30px;
            font-weight: 600;
            color: #1e1e1e;
            position: relative;
        }

        .similar-product-item {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .similar-product-item:hover {
            transform: translateY(-5px);
        }

        .similar-product-item .product-image {
            position: relative;
            border: 1px solid #eee;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 300px;
            padding: 10px;
            overflow: hidden;
        }

        .similar-product-item .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .similar-product-item .product-title {
            font-size: 15px;
            color: #1e1e1e;
            margin-top: 10px;
            font-weight: 500;
        }

        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .feature-icons-container {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                margin-bottom: 30px;
            }

            .feature-icon-item {
                margin: 0 10px 20px;
            }

            .product-image-main {
                margin-bottom: 30px;
            }

            .product-model-title {
                font-size: 28px;
            }
        }

        @media (max-width: 767px) {
            .page-product-detail {
                padding: 30px 0;
            }

            .feature-icon {
                width: 60px;
                height: 60px;
            }

            .feature-icon i {
                font-size: 24px;
            }

            .depth-number {
                font-size: 24px;
            }

            .feature-label {
                font-size: 10px;
            }

            .similar-product-item .product-image {
                height: 220px;
            }
        }
    </style>
@endpush
