@extends('layouts.app')
@section('content')
    <div class="page-project-single">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Product Sidebar Start -->
                    <div class="project-single-sidebar">
                        <!-- Product Details List -->
                        <div class="project-detail-list wow fadeInUp">
                            <div class="project-detail-title">
                                <h3>Product Details</h3>
                            </div>

                            <!-- Price -->
                            <div class="project-detail-item">
                                <div class="icon-box">
                                    <i class="fa-regular fa-calendar"></i>
                                </div>
                                <div class="project-detail-content">
                                    <h3>Price</h3>
                                    <p>
                                        @if($product->is_on_sale)
                                            <span class="original-price"><del>${{ number_format($product->price, 2) }}</del></span>
                                            <span class="sale-price">${{ number_format($product->sale_price, 2) }}</span>
                                        @else
                                            <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Stock Status -->
                            <div class="project-detail-item">
                                <div class="icon-box">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div class="project-detail-content">
                                    <h3>Availability</h3>
                                    <p>
                                    <span class="{{ $product->is_in_stock ? 'text-success' : 'text-danger' }}">
                                        {{ $product->is_in_stock ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                        @if($product->is_in_stock)
                                            ({{ $product->stock_quantity }} available)
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Product Features -->
                            @if(count($product->features) > 0)
                                <div class="project-detail-item">
                                    <div class="icon-box">
                                        <i class="fa-regular fa-circle-check"></i>
                                    </div>
                                    <div class="project-detail-content">
                                        <h3>Key Features</h3>
                                        <ul class="feature-list">
                                            @foreach($product->features as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <!-- Specifications -->
                            @if($product->specifications->count() > 0)
                                <div class="project-detail-item">
                                    <div class="icon-box">
                                        <i class="fa-solid fa-list"></i>
                                    </div>
                                    <div class="project-detail-content">
                                        <h3>Specifications</h3>
                                        <div class="specs-grid">
                                            @foreach($product->specifications as $spec)
                                                <div class="spec-item">
                                                    <span class="spec-label">{{ $spec->label }}:</span>
                                                    <span class="spec-value">{{ $spec->value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Support CTA Box -->
                        <div class="sidebar-cta-box wow fadeInUp" data-wow-delay="0.2s">
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
                    <!-- Main Product Content -->
                    <div class="project-single-content">
                        <!-- Main Product Image -->
                        <div class="project-single-image">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                     alt="{{ $product->name }}"
                                     data-cursor="-opaque">
                            </figure>
                        </div>

                        <!-- Product Description -->
                        <div class="project-entry">
                            <div class="project-info">
                                <h2 class="text-anime-style-3">{{ $product->name }}</h2>
                                <div class="wow fadeInUp">
                                    {!! Purifier::clean($product->description) !!}
                                </div>
                            </div>

                            <!-- Image Gallery -->
                            @if($product->images->count() > 0)
                                <div class="project-gallery mt-5">
                                    <h2 class="text-anime-style-3">Product Gallery</h2>
                                    <div class="gallery-grid">
                                        @foreach($product->images as $image)
                                            <div class="gallery-item wow fadeInUp">
                                                <a href="{{ asset('storage/' . $image->image) }}"
                                                   data-fancybox="gallery"
                                                   data-cursor-text="VIEW">
                                                    <figure class="image-anime reveal">
                                                        <img src="{{ asset('storage/' . $image->image) }}"
                                                             alt="{{ $product->name }} - Image {{ $loop->iteration }}">
                                                    </figure>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image lightbox
            Fancybox.bind("[data-fancybox]", {
                Thumbs: false,
                Toolbar: {
                    display: [
                        { id: "prev", position: "left" },
                        { id: "next", position: "right" },
                    ],
                },
            });

            // Image hover effect
            document.querySelectorAll('.gallery-item img').forEach(img => {
                img.addEventListener('mouseenter', () => {
                    img.parentElement.style.transform = 'scale(1.02)';
                });
                img.addEventListener('mouseleave', () => {
                    img.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
@endpush
