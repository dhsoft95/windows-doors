@extends('layouts.app')

@section('content')
    <div class="product-detail-page">
        <div class="container-lg">
            <!-- Main Product Block -->
            <div class="product-main-block">
                <div class="row g-4">
                    <!-- Feature Icons Column -->
                    <div class="col-lg-2 col-md-3 order-md-1">
                        <div class="feature-icons-sidebar">
                            <div class="feature-card">
                                <div class="icon-wrapper">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <span class="feature-text">Israel/European<br>standard</span>
                            </div>

                            <div class="feature-card">
                                <div class="icon-wrapper">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <span class="feature-text">Self-destruct<br>mechanism</span>
                            </div>

                            <div class="feature-card">
                                <div class="icon-wrapper">
                                    <i class="fas fa-volume-off"></i>
                                </div>
                                <span class="feature-text">Thermal<br>and acoustic<br>insulation</span>
                            </div>

                            <div class="feature-card">
                                <div class="icon-wrapper">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <span class="feature-text">Strong<br>resistant door</span>
                            </div>

                            <div class="feature-card">
                                <div class="icon-wrapper">
                                    <span class="depth-number">25</span>
                                </div>
                                <span class="feature-text">High safety lock<br>25mm depth</span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Product Image -->
                    <div class="col-lg-5 col-md-9 order-md-2">
                        <div class="main-product-image">
                            <div class="image-container">
                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                     class="img-fluid"
                                     alt="{{ $product->name }}"
                                     loading="lazy">
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Column -->
                    <div class="col-lg-5 order-md-3">
                        <div class="product-details-card">
                            <!-- Product Header -->
                            <div class="product-header">
                                <h1 class="product-title">
                                    {{ $product->name}}
{{--                                    {{ $product->style_code ?? 'WINDOW ' . $product->id }}--}}
                                </h1>
                            </div>

                            <!-- Product Description -->
                            <div class="product-description">
                                {!! Purifier::clean($product->description) !!}
                            </div>

                            <!-- Specifications Table -->
                            @if($product->specifications->count() > 0)
                                <div class="specs-table">
                                    <h3 class="section-title">Technical Specifications</h3>
                                    <div class="specs-grid">
                                        @foreach($product->specifications as $spec)
                                            <div class="spec-row">
                                                <div class="spec-label">{{ $spec->label }}</div>
                                                <div class="spec-value">{{ $spec->value }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Features List -->
                            @if($product->features->count() > 0)
                                <div class="features-list">
                                    <h3 class="section-title">Key Features</h3>
                                    <ul class="features-grid">
                                        @foreach($product->features->flatMap->features as $feature)
                                            <li class="feature-item">
                                                <i class="fas fa-check"></i>{{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- CTA Section -->
                            <div class="cta-sectionn">
                                <a href="{{ route('contact') }}" class="inquiry-btn">
                                    <i class="fas fa-file-alt me-2"></i>Request Detailed Specifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Similar Products Section -->
            <div class="similar-products-section">
                <div class="section-header">
                    <h2>Related Products</h2>
                    <p class="section-subtitle">Explore similar security solutions</p>
                </div>

                <div class="similar-products-grid">
                    @foreach($product->relatedProducts as $relatedProduct)
                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="product-card">
                            <div class="card-image">
                                <img src="{{ asset('storage/' . $relatedProduct->main_image) }}"
                                     alt="{{ $relatedProduct->name }}"
                                     class="img-fluid"
                                     loading="lazy">
                            </div>

                            <div class="card-body">
                                <h3 class="product-model">
                                    {{ $relatedProduct->model_number ?? 'SL 7050' }}
                                </h3>
                                <p class="product-type">{{ $relatedProduct->style_code ?? 'WINDOW ' . $relatedProduct->id }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Base Styling */
        .product-detail-page {
            padding: 2.5rem 0;
            background: #ffffff;
        }

        /* Feature Icons Sidebar */
        .feature-icons-sidebar {
            display: grid;
            gap: 1rem;
        }

        .feature-card {
            padding: 1.25rem;
            border: 1px solid #ececec;
            border-radius: 8px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .feature-card:hover {
            border-color: #deaf33;
        }

        .icon-wrapper {
            width: 50px;
            height: 50px;
            border: 1px solid #ececec;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
        }

        .icon-wrapper i {
            font-size: 1.4rem;
            color: #deaf33;
        }

        .depth-number {
            font-size: 1.4rem;
            font-weight: 600;
            color: #deaf33;
        }

        .feature-text {
            font-size: 0.85rem;
            line-height: 1.3;
            color: #444444;
        }

        /* Main Product Image */
        .main-product-image {
            background: #ffffff;
            border: 1px solid #ececec;
            border-radius: 8px;
            padding: 1rem;
        }

        .image-container {
            position: relative;
            padding-top: 100%;
            overflow: hidden;
            border-radius: 4px;
        }

        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Product Details Card */
        .product-details-card {
            padding: 1.5rem;
            background: #ffffff;
            border: 1px solid #ececec;
            border-radius: 8px;
        }

        .product-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #222222;
            margin-bottom: 1.25rem;
        }

        .product-description {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #444444;
            margin-bottom: 1.5rem;
        }

        /* Specifications Grid */
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #222222;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #deaf33;
        }

        .specs-grid {
            display: grid;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .spec-label {
            font-size: 0.9rem;
            color: #666666;
        }

        .spec-value {
            font-size: 0.9rem;
            color: #222222;
            font-weight: 500;
        }

        /* Features List */
        .features-grid {
            columns: 2;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .feature-item {
            font-size: 0.9rem;
            color: #444444;
            margin-bottom: 0.5rem;
            break-inside: avoid;
        }

        .feature-item i {
            color: #deaf33;
            margin-right: 0.5rem;
        }

        /* CTA Button */
        .inquiry-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.75rem;
            background-color: #deaf33;
            color: #222222;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .inquiry-btn:hover {
            background-color: #c79b2b;
            color: #222222;
        }

        /* Similar Products Section */
        .similar-products-section {
            margin-top: 3rem;
            padding-top: 3rem;
            border-top: 1px solid #ececec;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .section-header h2 {
            font-size: 1.5rem;
            color: #222222;
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            font-size: 0.95rem;
            color: #666666;
        }

        .similar-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            border: 1px solid #ececec;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .product-card:hover {
            border-color: #deaf33;
            transform: translateY(-3px);
        }

        .card-image {
            padding: 1.5rem;
            background: #f9f9f9;
            text-align: center;
        }

        .card-body {
            padding: 1rem;
            text-align: center;
        }

        .product-model {
            font-size: 1rem;
            color: #222222;
            margin-bottom: 0.25rem;
        }

        .product-type {
            font-size: 0.85rem;
            color: #666666;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .feature-icons-sidebar {
                grid-template-columns: repeat(3, 1fr);
            }

            .product-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 768px) {
            .feature-icons-sidebar {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-grid {
                columns: 1;
            }

            .similar-products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .product-detail-page {
                padding: 1.5rem 0;
            }

            .similar-products-grid {
                grid-template-columns: 1fr;
            }
        }


    </style>
@endpush
