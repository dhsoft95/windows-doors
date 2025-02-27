@extends('layouts.app')
@section('content')
    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque">Our Product Catalogue</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Catalogue</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Catalogue Section Start -->
    <div class="catalogue-section">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">browse our catalogue</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Explore Our Complete Product Range</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Discover our comprehensive collection of premium doors and windows. Browse through our interactive catalogue to find the perfect solutions for your home or business.</p>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <!-- PDF Viewer Container -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="pdf-viewer-container wow fadeInUp" data-wow-delay="0.4s">
                        <div id="pdf-container">
                            <div id="pdf-viewer"></div>
                            <div id="page-loader" class="loading-indicator">
                                <div class="spinner"></div>
                                <p>Loading catalogue...</p>
                            </div>
                        </div>

                        <!-- PDF Viewer Controls -->
                        <div class="pdf-controls">
                            <button id="prev-page" class="btn-default btn-sm"><i class="fa fa-chevron-left"></i> Previous</button>
                            <span id="page-num">Page <span id="current-page">1</span> of <span id="total-pages">0</span></span>
                            <button id="next-page" class="btn-default btn-sm">Next <i class="fa fa-chevron-right"></i></button>
                            <button id="zoom-in" class="btn-default btn-sm ml-3"><i class="fa fa-search-plus"></i></button>
                            <button id="zoom-out" class="btn-default btn-sm"><i class="fa fa-search-minus"></i></button>
                            <a href="{{ asset('pdf/Simba dw - Catalogue ( Second Draft ).pdf') }}" download class="btn-default btn-highlighted btn-sm ml-3"><i class="fa fa-download"></i> Download PDF</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catalogue Description -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="catalogue-description wow fadeInUp" data-wow-delay="0.6s">
                        <h3>What's Inside Our Catalogue</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="catalogue-feature">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-about-facility-1.svg') }}" alt="Security Doors">
                                    </div>
                                    <h4>Security Doors</h4>
                                    <p>Explore our range of high-security doors that combine safety with elegant design.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="catalogue-feature">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-about-facility-2.svg') }}" alt="Interior Doors">
                                    </div>
                                    <h4>Interior Doors</h4>
                                    <p>Discover our collection of wood and metal interior doors for every room in your home.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="catalogue-feature">
                                    <div class="icon-box">
                                        <img src="{{ asset('images/icon-about-facility-3.svg') }}" alt="Aluminum Solutions">
                                    </div>
                                    <h4>Aluminum Solutions</h4>
                                    <p>View our premium aluminum windows and doors with safety glass and modern designs.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Request Physical Catalogue -->
            <div class="row mt-5">
                <div class="col-lg-8 offset-lg-2">
                    <div class="physical-catalogue-box wow fadeInUp" data-wow-delay="0.8s">
                        <h3>Request a Physical Catalogue</h3>
                        <p>Would you prefer a printed copy of our catalogue? Fill out the form below, and we'll mail one directly to you.</p>

                        <form id="catalogueRequestForm" class="mt-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="Full Name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" class="form-control" placeholder="Email Address" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="tel" class="form-control" placeholder="Phone Number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="City" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <textarea class="form-control" rows="3" placeholder="Delivery Address" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn-default">Request Catalogue</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Catalogue Section End -->

    <!-- External Libraries for PDF Viewer -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/build/pdf.min.js"></script>

    <!-- Custom Styles for PDF Viewer -->
    <style>
        .pdf-viewer-container {
            margin: 40px auto;
            position: relative;
        }

        #pdf-container {
            width: 100%;
            height: 700px;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        #pdf-viewer {
            width: 100%;
            height: 100%;
            overflow: auto;
        }

        #pdf-viewer canvas {
            margin: 0 auto;
            display: block;
        }

        .loading-indicator {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(247, 247, 247, 0.9);
            z-index: 10;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #ddd;
            border-top: 5px solid #333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .pdf-controls {
            margin-top: 20px;
            text-align: center;
        }

        #page-num {
            display: inline-block;
            margin: 0 15px;
            font-weight: 500;
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 14px;
            margin: 0 2px;
        }

        .ml-3 {
            margin-left: 15px;
        }

        .catalogue-description {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
        }

        .catalogue-feature {
            text-align: center;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .catalogue-feature:hover {
            transform: translateY(-5px);
        }

        .catalogue-feature .icon-box {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .catalogue-feature h4 {
            margin-bottom: 10px;
        }

        .physical-catalogue-box {
            background: #f1f1f1;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
        }
    </style>

    <!-- PDF Viewer JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pdfUrl = "{{ asset('pdf/Simba dw - Catalogue ( Second Draft ).pdf') }}";
            const container = document.getElementById('pdf-viewer');
            const pageLoader = document.getElementById('page-loader');
            const currentPageElement = document.getElementById('current-page');
            const totalPagesElement = document.getElementById('total-pages');

            let pdfDoc = null;
            let currentPage = 1;
            let scale = 1.0;
            const DEFAULT_SCALE = 1.0;

            // Initialize PDF.js
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/build/pdf.worker.min.js';

            function renderPage(pageNum) {
                pageLoader.style.display = 'flex';

                pdfDoc.getPage(pageNum).then(function(page) {
                    const viewport = page.getViewport({ scale });

                    // Create or reuse canvas
                    let canvas = container.querySelector('canvas');
                    if (!canvas) {
                        canvas = document.createElement('canvas');
                        container.appendChild(canvas);
                    }

                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Render PDF page
                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    page.render(renderContext).promise.then(function() {
                        pageLoader.style.display = 'none';
                        currentPageElement.textContent = pageNum;
                    });
                });
            }

            // Load the PDF
            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                pdfDoc = pdf;
                totalPagesElement.textContent = pdf.numPages;
                renderPage(currentPage);
            }).catch(function(error) {
                console.error('Error loading PDF:', error);
                container.innerHTML = '<div class="error-message">Error loading catalogue. Please try again later or download the PDF directly.</div>';
                pageLoader.style.display = 'none';
            });

            // Previous page button
            document.getElementById('prev-page').addEventListener('click', function() {
                if (currentPage <= 1) return;
                currentPage--;
                renderPage(currentPage);
            });

            // Next page button
            document.getElementById('next-page').addEventListener('click', function() {
                if (!pdfDoc || currentPage >= pdfDoc.numPages) return;
                currentPage++;
                renderPage(currentPage);
            });

            // Zoom in button
            document.getElementById('zoom-in').addEventListener('click', function() {
                scale += 0.25;
                renderPage(currentPage);
            });

            // Zoom out button
            document.getElementById('zoom-out').addEventListener('click', function() {
                if (scale <= 0.5) return;
                scale -= 0.25;
                renderPage(currentPage);
            });

            // Catalogue request form
            document.getElementById('catalogueRequestForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you for your request. A physical catalogue will be sent to your address shortly.');
                this.reset();
            });
        });
    </script>
@endsection
