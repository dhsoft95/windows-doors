@extends('layouts.app')

@section('content')
    <div class="page-project-single">
        <div class="container">
            <div class="row g-4">
                <!-- Sidebar Column -->
                <div class="col-lg-4">
                    <div class="project-single-sidebar">
                        <!-- Product Details Card -->
                        <div class="product-detail-card mb-4">
                            <div class="product-detail-header mb-3">
                                <h3 class="fw-semibold">Product Details</h3>
                                <div class="header-underline"></div>
                            </div>

                            <!-- Availability -->
                            <div class="product-detail-item align-items-start">
                                <div class="icon-circle me-3" style="background-color: #f9d56e;">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div class="detail-content">
                                    <h4 class="mb-1">Availability</h4>
                                    <div class="availability-tag">
                                    <span class="{{ $product->is_in_stock ? 'available' : 'unavailable' }}">
                                        {{ $product->is_in_stock ? 'Available' : 'Not Available' }}
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="product-detail-item align-items-start">
                                <div class="icon-circle me-3" style="background-color: #292929;">
                                    <i class="fa-regular fa-circle-check text-white"></i>
                                </div>
                                <div class="detail-content">
                                    <h4 class="mb-2">Key Features</h4>
                                    <ul class="feature-list">
                                        @forelse($product->features->flatMap->features as $feature)
                                            <li>{{ $feature }}</li>
                                        @empty
                                            <li>No features available</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                            <!-- Specifications -->
                            @if($product->specifications->count() > 0)
                                <div class="product-detail-item align-items-start">
                                    <div class="icon-circle me-3" style="background-color: #292929;">
                                        <i class="fa-solid fa-list text-white"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4 class="mb-2">Specifications</h4>
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

                            <!-- WhatsApp Button -->
                            <div class="whatsapp-inquiry-btn mt-3">
                                <a href="https://wa.me/255676111700?text=I'm%20interested%20in%20{{ urlencode($product->name) }}%20(SKU:%20{{ $product->sku }})"
                                   class="btn btn-whatsapp w-100"
                                   target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                    Inquire via WhatsApp
                                </a>
                            </div>
                        </div>

                        <!-- Support Card -->
                        <div class="need-help-box p-3">
                            <div class="help-box-title mb-3">
                                <h4 class="fw-semibold">Need Help?</h4>
                            </div>
                            <div class="help-contact-list">
                                <div class="help-contact-item mb-2">
                                    <div class="help-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div class="help-contact-content">
                                        <p>+255 676111700</p>
                                    </div>
                                </div>
                                <div class="help-contact-item">
                                    <div class="help-icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div class="help-contact-content">
                                        <p>info@simbadw.co.tz</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Column -->
                <div class="col-lg-8">
                    <div class="product-main-content">
                        <!-- Main Image -->
                        <div class="product-image-container mb-4">
                            <div class="img-magnifier-container">
                                <img id="mainProductImage"
                                     src="{{ asset('storage/' . $product->main_image) }}"
                                     alt="{{ $product->name }}"
                                     class="product-main-image">
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div class="product-info-section mb-5">
                            <h1 class="product-title mb-3">{{ $product->name }}</h1>
                            <div class="product-description">
                                {!! Purifier::clean($product->description) !!}
                            </div>
                        </div>

                        <!-- Gallery -->
                        @if($product->images->count() > 0)
                            <div class="product-gallery-section">
                                <h3 class="gallery-title mb-3">Product Gallery</h3>
                                <div class="gallery-grid row g-2">
                                    @foreach($product->images as $image)
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <a href="{{ asset('storage/' . $image->image) }}"
                                               class="gallery-item"
                                               data-fancybox="gallery">
                                                <img src="{{ asset('storage/' . $image->image) }}"
                                                     alt="{{ $product->name }} - Image {{ $loop->iteration }}"
                                                     class="gallery-image">
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
@endsection
@push('styles')
    <style>
        /* Overall page styling */
        .page-project-single {
            padding: 60px 0;
            background-color: #fff;
        }

        /* Product sidebar styling */
        .project-single-sidebar {
            margin-bottom: 30px;
        }

        .product-detail-card {
            border: 1px solid #e6e6e6;
            border-radius: 4px;
            padding: 25px;
            background-color: #fff;
            margin-bottom: 30px;
        }

        .product-detail-header {
            margin-bottom: 30px;
        }

        .product-detail-header h3 {
            color: #f9d56e;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .header-underline {
            width: 50px;
            height: 3px;
            background-color: #f9d56e;
            margin-bottom: 20px;
        }

        /* Icon styling */
        .icon-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 15px;
        }

        .icon-circle i {
            font-size: 20px;
        }

        /* Detail item styling */
        .product-detail-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-detail-item:last-child {
            border-bottom: none;
        }

        .detail-content h3 {
            font-size: 18px;
            margin-bottom: 12px;
            font-weight: 500;
        }

        /* Availability styling */
        .availability-tag {
            display: inline-block;
        }

        .availability-tag span {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
        }

        .availability-tag span.available {
            background-color: #e9f9e7;
            color: #333;
            border: 1px solid #d4ead1;
        }

        .availability-tag span.unavailable {
            background-color: #ffeeee;
            color: #333;
            border: 1px solid #f5d5d5;
        }

        /* Feature list styling */
        .feature-list {
            padding-left: 0;
            list-style-type: none;
            margin-bottom: 0;
        }

        .feature-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .feature-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            top: 0;
            color: #333;
        }

        /* Specifications styling */
        .specs-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .spec-item {
            display: flex;
            flex-wrap: wrap;
            padding: 8px 0;
            border-bottom: 1px dashed #f0f0f0;
        }

        .spec-item:last-child {
            border-bottom: none;
        }

        .spec-label {
            font-weight: 500;
            margin-right: 8px;
            color: #333;
        }

        /* WhatsApp button */
        .whatsapp-inquiry-btn {
            margin-top: 20px;
        }

        .btn-whatsapp {
            background-color: #25d366;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            font-weight: 500;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-whatsapp:hover {
            background-color: #1fb855;
            color: white;
            transform: translateY(-2px);
        }

        .btn-whatsapp i {
            font-size: 20px;
            margin-right: 10px;
        }

        /* Need Help box styling */
        .need-help-box {
            background-color: #f8f8f8;
            padding: 25px;
            border-radius: 4px;
        }

        .help-box-title h2 {
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .help-contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .help-icon {
            width: 36px;
            height: 36px;
            background-color: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .help-contact-content p {
            margin-bottom: 0;
            font-size: 15px;
        }

        /* Main product content styling */
        .product-main-content {
            background-color: #fff;
            border-radius: 4px;
            overflow: hidden;
        }

        /* IMPROVED: Product image styling with magnifier */
        .product-image-container {
            margin-bottom: 30px;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            position: relative;
            /* Increased height for bigger image */
            height: 700px;
        }

        .img-magnifier-container {
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-main-image {
            max-width: 100%;
            max-height: 680px;
            object-fit: contain;
            transition: transform 0.3s ease;
            cursor: zoom-in;
            /* Center the image */
            display: block;
            margin: 0 auto;
            /* Added border radius to the image */
            border-radius: 8px;
        }

        /* Product info styling */
        .product-info-section {
            padding: 0 0 30px 0;
        }

        .product-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .product-description {
            color: #555;
            line-height: 1.6;
        }

        .product-description p {
            margin-bottom: 15px;
        }

        /* Gallery styling */
        .product-gallery-section {
            margin-top: 20px;
            padding-bottom: 30px;
        }

        .gallery-title {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
        }

        .gallery-item {
            border: 1px solid #f0f0f0;
            border-radius: 4px;
            overflow: hidden;
            transition: all 0.3s ease;
            /* Fixed height for gallery items */
            height: 180px;
        }

        .gallery-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
            padding: 10px;
        }

        /* IMPROVED: Image magnifier glass */
        .magnifier-glass {
            position: fixed;
            border: 2px solid #f9d56e;
            border-radius: 50%;
            cursor: none;
            width: 200px;
            height: 200px;
            background-repeat: no-repeat;
            display: none;
            box-shadow: 0 3px 15px rgba(0,0,0,0.15);
            pointer-events: none;
            z-index: 1000;
        }

        /* Responsive adjustments */
        @media (max-width: 1199px) {
            .product-image-container {
                height: 600px;
            }

            .product-main-image {
                max-height: 570px;
            }
        }

        @media (max-width: 991px) {
            .page-project-single {
                padding: 40px 0;
            }

            .product-title {
                font-size: 24px;
            }

            .product-image-container {
                height: 550px;
            }

            .product-main-image {
                max-height: 520px;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }

            .gallery-item {
                height: 140px;
            }
        }

        @media (max-width: 768px) {
            .product-image-container {
                height: 500px;
            }

            .product-main-image {
                max-height: 470px;
            }
        }

        @media (max-width: 576px) {
            .product-image-container {
                height: 450px;
            }

            .product-main-image {
                max-height: 420px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image lightbox
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind("[data-fancybox]", {
                    Thumbs: {
                        autoStart: true,
                        position: "bottom",
                    },
                    Toolbar: {
                        display: [
                            { id: "prev", position: "center" },
                            { id: "counter", position: "center" },
                            { id: "next", position: "center" },
                            { id: "zoom", position: "right" },
                            { id: "fullscreen", position: "right" },
                            { id: "close", position: "right" },
                        ],
                    },
                    Image: {
                        zoom: true,
                    },
                    Carousel: {
                        transition: "slide",
                    },
                });
            }

            // FIXED: Image magnifier function
            function magnify(imgID, zoom) {
                var img, glass, w, h, bw;
                img = document.getElementById(imgID);

                if (!img) return;

                // Create magnifier glass if it doesn't exist already
                glass = document.querySelector('.magnifier-glass');

                if (!glass) {
                    glass = document.createElement("DIV");
                    glass.setAttribute("class", "magnifier-glass");

                    // Insert magnifier glass
                    img.parentElement.insertBefore(glass, img);
                }

                // Get dimensions after image is fully loaded
                function setupMagnifier() {
                    // Get the real dimensions of the image
                    const imgWidth = img.naturalWidth;
                    const imgHeight = img.naturalHeight;

                    // Set background properties with the correct dimensions
                    glass.style.backgroundImage = "url('" + img.src + "')";
                    glass.style.backgroundSize = (imgWidth * zoom) + "px " + (imgHeight * zoom) + "px";

                    // Set magnifier size
                    bw = 3; // Border width
                    w = glass.offsetWidth / 2;
                    h = glass.offsetHeight / 2;
                }

                // Set up the magnifier immediately and after image loads to ensure correct dimensions
                setupMagnifier();

                // Set up again when image is fully loaded
                if (!img.complete) {
                    img.onload = setupMagnifier;
                }

                // Execute function when mouse moves over the image
                img.addEventListener("mousemove", moveMagnifier);
                glass.addEventListener("mousemove", moveMagnifier);

                // Show glass on mouseenter
                img.addEventListener("mouseenter", function() {
                    glass.style.display = "block";
                });

                // Hide glass on mouseleave
                img.addEventListener("mouseleave", function() {
                    glass.style.display = "none";
                });

                function moveMagnifier(e) {
                    var pos, x, y;
                    // Prevent default action
                    e.preventDefault();

                    // Get the bounds of the image
                    const rect = img.getBoundingClientRect();

                    // Get cursor position
                    pos = getCursorPos(e);
                    x = pos.x;
                    y = pos.y;

                    // Calculate magnifier position relative to cursor
                    glass.style.left = (e.clientX - w) + "px";
                    glass.style.top = (e.clientY - h) + "px";

                    // Calculate background position - scaling according to image natural dimensions
                    const scaleX = img.naturalWidth / rect.width;
                    const scaleY = img.naturalHeight / rect.height;

                    // Display what the magnifier "sees"
                    glass.style.backgroundPosition = "-" + ((x * scaleX * zoom) - w) + "px -" + ((y * scaleY * zoom) - h) + "px";
                }

                function getCursorPos(e) {
                    var a, x = 0, y = 0;
                    e = e || window.event;

                    // Get image position
                    a = img.getBoundingClientRect();

                    // Calculate cursor position relative to the image
                    x = e.pageX - a.left - window.pageXOffset;
                    y = e.pageY - a.top - window.pageYOffset;

                    return {x : x, y : y};
                }
            }

            // Call the magnify function with a zoom level of 3 (increased from 2.5)
            // Wait for the image to be fully loaded
            const mainImage = document.getElementById("mainProductImage");

            if (mainImage) {
                if (mainImage.complete) {
                    magnify("mainProductImage", 3);
                } else {
                    mainImage.onload = function() {
                        magnify("mainProductImage", 3);
                    };
                }
            }

            // Refresh magnifier on window resize
            window.addEventListener('resize', function() {
                // Remove existing magnifier
                const existingGlass = document.querySelector('.magnifier-glass');
                if (existingGlass) {
                    existingGlass.remove();
                }

                // Reinitialize after a short delay to let layout update
                setTimeout(function() {
                    magnify("mainProductImage", 3);
                }, 100);
            });
        });
    </script>
@endpush
