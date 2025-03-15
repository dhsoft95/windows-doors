{{-- resources/views/layouts/partials/header.blade.php --}}

<!-- Preloader Start -->
<div class="preloader">
    <div class="loading-container">
        <div class="loading"></div>
        <div id="loading-icon"><img src="{{ asset('images/loader.svg') }}" alt="Loading"></div>
    </div>
</div>
<!-- Preloader End -->

<!-- Topbar Section Start -->
<div class="topbar" style="background-color: #deaf33!important;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="topbar-contact-info">
                    <ul>
                        <li>
                            <a href="#">
                                <img src="{{ asset('images/icon-location.svg') }}" alt="Location">
                                Dar es Salaam, Tanzania
                            </a>
                        </li>
                        <li>
                            <a href="mailto:{{ config('app.contact_email', 'info@simbadw.co.tz') }}">
                                <img src="{{ asset('images/icon-mail.svg') }}" alt="Email">
                                {{ config('app.contact_email', 'info@simbadw.co.tz') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="topbar-offer">
                    <p>{{ config('app.company_tagline', 'Over 30 Years of Excellence in Door & Window Solutions') }}</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="topbar-time">
                    <ul>
                        <li>
                            <a href="#">
                                <img src="{{ asset('images/icon-clock.svg') }}" alt="Hours">
                                {{ config('app.business_hours', 'Mon-Fri 8:00 - 17:00 / Sat 9:00 - 13:00') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar Section End -->

<!-- Header Start -->
<header class="main-header" style="background-color: #1e1e1e!important; color: #1e1e1e">
    <div class="header-sticky">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo Start -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" width="150" height="60"
                         alt="{{ config('app.name') }} Logo">
                </a>
                <!-- Logo End -->

                <!-- Main Menu Start -->
                <div class="collapse navbar-collapse main-menu">
                    <div class="nav-menu-wrapper">
                        <ul class="navbar-nav mr-auto" id="menu">
                            @foreach(config('navigation.main', [
                                ['name' => 'Home', 'route' => 'home', 'children' => []],
                                ['name' => 'About', 'route' => 'about', 'children' => []],
                                ['name' => 'Products', 'route' => 'products.index', 'children' => [
                                    ['name' => 'All Products', 'route' => 'products.index'],
                                    ['name' => 'Categories', 'route' => 'categories.index']
                                ]],
                                ['name' => 'Articles', 'route' => null, 'children' => [
                                    ['name' => 'blog', 'route' => 'articles.index'],
//                                    ['name' => 'News', 'route' => 'articles.news'],
//                                    ['name' => 'Installation Guides', 'route' => 'articles.guides']
                                ]],
                                ['name' => 'Catalogue', 'route' => 'catalogue', 'children' => []],
//                                ['name' => 'Help & Support', 'route' => 'support', 'children' => []],
//                                ['name' => 'Show Room', 'route' => 'showroom', 'children' => []]
                            ]) as $menuItem)
                                <li class="nav-item {{ !empty($menuItem['children']) ? 'submenu' : '' }} {{ request()->routeIs($menuItem['route'] ?? 'none') || (isset($menuItem['children']) && collect($menuItem['children'])->contains(function($child) { return request()->routeIs($child['route'] ?? 'none'); })) ? 'active' : '' }}">
                                    <a class="nav-link"
                                       href="{{ $menuItem['route'] ? route($menuItem['route']) : '#' }}">{{ $menuItem['name'] }}</a>

                                    @if(!empty($menuItem['children']))
                                        <ul>
                                            @foreach($menuItem['children'] as $child)
                                                <li class="nav-item {{ request()->routeIs($child['route'] ?? 'none') ? 'active' : '' }}">
                                                    <a class="nav-link"
                                                       href="{{ route($child['route']) }}">{{ $child['name'] }}</a>

                                                    @if($menuItem['name'] === 'Products' && $child['name'] === 'Categories')
                                                        <ul>
                                                            @foreach($categories as $category)
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="{{ route('categories.show', $category->slug) }}">
                                                                        {{ $category->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Header Social Icons Start -->
                    <div class="header-social-icons">
                        <ul>
                            @foreach(config('social_media', [
                                ['platform' => 'facebook', 'url' => '#', 'icon' => 'fa-brands fa-facebook'],
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
                    <!-- Header Social Icons End -->
                </div>
                <!-- Main Menu End -->
                <div class="navbar-toggle"></div>
            </div>
        </nav>
        <div class="responsive-menu"></div>
    </div>
</header>
<!-- Header End -->
