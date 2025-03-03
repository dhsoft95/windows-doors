{{-- resources/views/layouts/partials/footer.blade.php --}}

<!-- Footer Ticker Start -->
<div class="footer-ticker">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- Scrolling Ticker Start -->
                <div class="scrolling-ticker">
                    <!-- Scrolling Ticker Box Start -->
                    <div class="scrolling-ticker-box">
                        <!-- Scrolling Ticker Content Start -->
                        <div class="scrolling-content">
                            <span>{{ config('app.ticker_text', 'Transform Your Space with Simba\'s Premium Doors and Windows') }}</span>
                            <span>{{ config('app.ticker_text', 'Transform Your Space with Simba\'s Premium Doors and Windows') }}</span>
                        </div>
                        <!-- Scrolling Ticker Content End -->
                        <!-- Scrolling Ticker Content Start -->
                        <div class="scrolling-content">
                            <span>{{ config('app.ticker_text', 'Transform Your Space with Simba\'s Premium Doors and Windows') }}</span>
                            <span>{{ config('app.ticker_text', 'Transform Your Space with Simba\'s Premium Doors and Windows') }}</span>
                        </div>
                        <!-- Scrolling Ticker Content End -->
                    </div>
                    <!-- Scrolling Ticker Box End -->

                    <!-- Schedule Now Button Start -->
                    <div class="schedule-now-btn">
                        <a href="mailto:sales@simbadw.co.tz" class="schedule-btn">get a quote</a>
                    </div>
                    <!-- Schedule Now Button End -->
                </div>
                <!-- Scrolling Ticker End -->
            </div>
        </div>
    </div>
</div>
<!-- Footer Ticker End -->

<footer class="main-footer" style="background-color: #1e1e1e">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Footer Header Start -->
                <div class="footer-header">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="footer-header-title">
                                <!-- Section Title Start -->
                                <div class="section-title dark-section">
                                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ config('app.footer_heading', 'Unlock Your Dream Design Today!') }}</h2>
                                </div>
                                <!-- Section Title End -->
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-4">
                            <!-- Footer Contact Button Start -->
                            <div class="footer-contact-btn">
                                <a href="{{ route('showroom') }}" class="btn-default btn-highlighted">visit our showroom</a>
                            </div>
                            <!-- Footer Contact Button End -->
                        </div>
                    </div>
                </div>
                <!-- Footer Header End -->
            </div>

            <div class="col-lg-3 col-md-6">
                <!-- About Footer Start -->
                <div class="about-footer">
                    <!-- Footer Logo Start -->
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" width="130" height="50" alt="{{ config('app.name') }} Logo">
                    </div>
                    <!-- Footer Logo End -->

                    <!-- About Footer Content Start -->
                    <div class="about-footer-content">
                        <p>{{ config('app.footer_tagline', 'Quality Design Excellence in Doors & Windows for Over 30 Years') }}</p>
                    </div>
                    <!-- About Footer Content End -->

                    <!-- Footer Social Link Start -->
                    <div class="footer-social-links">
                        <ul>
                            @foreach(config('social_media', [
                                ['platform' => 'facebook', 'url' => '#', 'icon' => 'fa-brands fa-facebook-f'],
                                ['platform' => 'instagram', 'url' => '#', 'icon' => 'fa-brands fa-instagram'],
                                ['platform' => 'linkedin', 'url' => '#', 'icon' => 'fa-brands fa-linkedin']
                            ]) as $socialLink)
                                <li>
                                    <a href="{{ $socialLink['url'] }}"
                                       aria-label="{{ ucfirst($socialLink['platform']) }}"
                                       target="_blank"
                                       rel="noopener">
                                        <i class="{{ $socialLink['icon'] }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Footer Social Link End -->
                </div>
                <!-- About Footer End -->
            </div>

            <div class="col-lg-3 col-md-6">
                <!-- Footer Links Start -->
                <div class="footer-links">
                    <h3>quick links</h3>
                    <ul>
                        @foreach(config('navigation.footer', [
                            ['name' => 'Home', 'route' => 'home'],
                            ['name' => 'About', 'route' => 'about'],
//                            ['name' => 'Products', 'route' => 'products.index'],
                            ['name' => 'Catalogue', 'route' => 'catalogue'],
                            ['name' => 'Help & Support', 'route' => 'support'],
                            ['name' => 'Contact', 'route' => 'contact']
                        ]) as $link)
                            <li><a href="{{ route($link['route']) }}">{{ $link['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- Footer Links End -->
            </div>

            <div class="col-lg-3 col-md-6">
                <!-- Footer Contact Box Start -->
                <div class="footer-contact-box footer-links">
                    <h3>contact us</h3>

                    <!-- Footer Contact Item Start -->
                    <div class="footer-contact-item">
                        <div class="icon-box">
                            <img src="{{ asset('images/icon-mail.svg') }}" alt="Email">
                        </div>
                        <div class="footer-contact-content">
                            <p><a href="mailto:{{ config('app.contact_email', 'info@simbadoors.co.tz') }}">{{ config('app.contact_email', 'info@simbadw.co.tz') }}</a></p>
                        </div>
                    </div>
                    <!-- Footer Contact Item End -->

                    <!-- Footer Contact Item Start -->
                    <div class="footer-contact-item">
                        <div class="icon-box">
                            <img src="{{ asset('images/icon-phone.svg') }}" alt="Phone">
                        </div>
                        <div class="footer-contact-content">
                            <p><a href="tel:{{ preg_replace('/\s+/', '', config('app.contact_phone', '+255 676 111 700')) }}">{{ config('app.contact_phone', '+255 676 111 700') }}</a></p>
                        </div>
                    </div>
                    <!-- Footer Contact Item End -->

                    <!-- Footer Contact Item Start -->
                    <div class="footer-contact-item">
                        <div class="icon-box">
                            <img src="{{ asset('images/icon-location.svg') }}" alt="Location">
                        </div>
                        <div class="footer-contact-content">
                            <p>{{ config('app.address', 'Dar es Salaam, Tanzania') }}</p>
                        </div>
                    </div>
                    <!-- Footer Contact Item End -->
                </div>
                <!-- Footer Contact Box End -->
            </div>

            <div class="col-lg-3 col-md-6">
                <!-- Footer Newsletter Box Start -->
                <div class="footer-newsletter-box footer-links">
                    <h3>stay updated</h3>

                    <!-- Newsletter Form start -->
                    <div class="footer-latest-news-form">
                        <form id="latestnewsForm" action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       id="mail" placeholder="Enter your email" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="latestnews-btn">
                                    <img src="{{ asset('images/arrow-white.svg') }}" alt="Submit">
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Newsletter Form end -->
                </div>
                <!-- Footer Newsletter Box End -->
            </div>
        </div>

        <!-- Footer Copyright Section Start -->
        <div class="footer-copyright">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Footer Copyright Start -->
                    <div class="footer-copyright-text">
                        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Simba Doors and Windows') }}. All Rights Reserved.</p>
                    </div>
                    <!-- Footer Copyright End -->
                </div>
            </div>
        </div>
        <!-- Footer Copyright Section End -->
    </div>
</footer>
