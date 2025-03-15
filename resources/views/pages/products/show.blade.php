@extends('layouts.app')
@section('content')
    <div class="page-project-single">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Product Sidebar Start -->
                    <div class="project-single-sidebar">
                        <!-- Product Details List -->
                        <div class="product-detail-card wow fadeInUp">
                            <div class="product-detail-header">
                                <h3>Product Details</h3>
                                <div class="header-underline"></div>
                            </div>

                            <!-- Stock Status - Simplified -->
                            <div class="product-detail-item">
                                <div class="icon-circle" style="background-color: #f9d56e;">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div class="detail-content">
                                    <h3>Availability</h3>
                                    <div class="availability-tag">
                                        <span class="{{ $product->is_in_stock ? 'available' : 'unavailable' }}">
                                            {{ $product->is_in_stock ? 'Available' : 'Not Available' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Features -->
                            <div class="product-detail-item">
                                <div class="icon-circle" style="background-color: #292929;">
                                    <i class="fa-regular fa-circle-check text-white"></i>
                                </div>
                                <div class="detail-content">
                                    <h3>Key Features</h3>
                                    <ul class="feature-list">
                                        @php
                                            $hasFeatures = false;
                                        @endphp

                                        @if($product->features && $product->features->count() > 0)
                                            @foreach($product->features as $featureRecord)
                                                @php
                                                    // Use your accessor method directly without manual decoding
                                                    $featuresArray = $featureRecord->features;
                                                @endphp

                                                @if(is_array($featuresArray) && count($featuresArray) > 0)
                                                    @php $hasFeatures = true; @endphp
                                                    @foreach($featuresArray as $feature)
                                                        <li>{{ $feature }}</li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif

                                        @if(!$hasFeatures)
                                            <li>No features available</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <!-- Specifications -->
                            @if($product->specifications->count() > 0)
                                <div class="product-detail-item">
                                    <div class="icon-circle" style="background-color: #292929;">
                                        <i class="fa-solid fa-list text-white"></i>
                                    </div>
                                    <div class="detail-content">
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

                            <!-- WhatsApp Button -->
                            <div class="whatsapp-inquiry-btn">
                                <a href="https://wa.me/255676111700?text=I'm%20interested%20in%20{{ urlencode($product->name) }}%20(SKU:%20{{ $product->sku }})"
                                   class="btn btn-whatsapp"
                                   target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                    Inquire via WhatsApp
                                </a>
                            </div>
                        </div>

                        <!-- Support CTA Box -->
                        <div class="need-help-box wow fadeInUp" data-wow-delay="0.2s">
                            <div class="help-box-title">
                                <h2>Need Help?</h2>
                            </div>
                            <div class="help-contact-list">
                                <div class="help-contact-item">
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

                <div class="col-lg-8">
                    <!-- Main Product Content -->
                    <div class="product-main-content">
                        <!-- Main Product Image with Magnifier -->
                        <div class="product-image-container">
                            <div class="img-magnifier-container">
                                <figure>
                                    <img id="mainProductImage" src="{{ asset('storage/' . $product->main_image) }}"
                                         alt="{{ $product->name }}"
                                         class="product-main-image img-fluid">
                                </figure>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div class="product-info-section">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            <div class="product-description">
                                {!! Purifier::clean($product->description) !!}
                            </div>
                        </div>

                        <!-- Image Gallery -->
                        @if($product->images->count() > 0)
                            <div class="product-gallery-section">
                                <h2 class="gallery-title">Product Gallery</h2>
                                <div class="gallery-grid">
                                    @foreach($product->images as $image)
                                        <div class="gallery-item wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                                            <a href="{{ asset('storage/' . $image->image) }}"
                                               data-fancybox="gallery">
                                                <figure>
                                                    <img src="{{ asset('storage/' . $image->image) }}"
                                                         alt="{{ $product->name }} - Image {{ $loop->iteration }}"
                                                         class="gallery-image">
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

        /* Product image styling with magnifier */
        .product-image-container {
            margin-bottom: 30px;
            border: 1px solid #f0f0f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .img-magnifier-container {
            position: relative;
            overflow: hidden;
        }

        .product-main-image {
            width: 100%;
            height: 500px;
            object-fit: contain;
            transition: transform 0.3s ease;
            cursor: zoom-in;
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
        }

        .gallery-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .gallery-image {
            width: 100%;
            height: 160px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        /* Image magnifier glass */
        .magnifier-glass {
            position: absolute;
            border: 2px solid #fff;
            border-radius: 50%;
            cursor: none;
            width: 150px;
            height: 150px;
            background-repeat: no-repeat;
            display: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            pointer-events: none;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .page-project-single {
                padding: 40px 0;
            }

            .product-title {
                font-size: 24px;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image lightbox
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

            // Initialize image magnifier
            function magnify(imgID, zoom) {
                var img, glass, w, h, bw;
                img = document.getElementById(imgID);

                if (!img) return;

                // Create magnifier glass
                glass = document.createElement("DIV");
                glass.setAttribute("class", "magnifier-glass");

                // Insert magnifier glass
                img.parentElement.insertBefore(glass, img);

                // Set background properties
                glass.style.backgroundImage = "url('" + img.src + "')";
                glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";

                // Set magnifier size
                bw = 2; // Border width
                w = glass.offsetWidth / 2;
                h = glass.offsetHeight / 2;

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

                    // Get cursor position
                    pos = getCursorPos(e);
                    x = pos.x;
                    y = pos.y;

                    // Prevent magnifier from being positioned outside the image
                    if (x > img.width - (w / zoom)) {x = img.width - (w / zoom);}
                    if (x < w / zoom) {x = w / zoom;}
                    if (y > img.height - (h / zoom)) {y = img.height - (h / zoom);}
                    if (y < h / zoom) {y = h / zoom;}

                    // Set position of magnifier
                    glass.style.left = (x - w) + "px";
                    glass.style.top = (y - h) + "px";

                    // Display what the magnifier "sees"
                    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
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

            // Call the magnify function with a zoom level of 2.5
            magnify("mainProductImage", 2.5);
        });
    </script>
@endpush
