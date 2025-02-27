@extends('layouts.app')
@section('content')

    <!-- Page Contact Us Start -->
    <div class="page-contact-us">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">contact details</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">We're Here to Help with Your Door & Window Needs</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Contact Info Item Start -->
                    <div class="contact-info-item wow fadeInUp">
                        <div class="contact-info-img">
                            <figure class="image-anime">
                                <img src="images/contact-info-img-1.jpg" alt="Simba Doors and Windows Location">
                            </figure>
                        </div>

                        <div class="contact-info-content">
                            <h3>our location:</h3>
                            <p>Dar es Salaam, Tanzania</p>
                            <p>Visit our showroom to see our products in person</p>
                        </div>
                    </div>
                    <!-- Contact Info Item End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Contact Info Item Start -->
                    <div class="contact-info-item wow fadeInUp" data-wow-delay="0.2s">
                        <div class="contact-info-img">
                            <figure class="image-anime">
                                <img src="images/contact-info-img-2.jpg" alt="Simba Doors and Windows Email">
                            </figure>
                        </div>

                        <div class="contact-info-content">
                            <h3>emails:</h3>
                            <p>info@simbadoors.co.tz</p>
                            <p>sales@simbadoors.co.tz</p>
                        </div>
                    </div>
                    <!-- Contact Info Item End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Contact Info Item Start -->
                    <div class="contact-info-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="contact-info-img">
                            <figure class="image-anime">
                                <img src="images/contact-info-img-3.jpg" alt="Simba Doors and Windows Phone">
                            </figure>
                        </div>

                        <div class="contact-info-content">
                            <h3>phones:</h3>
                            <p>Sales: +255 XXX XXX XXX</p>
                            <p>Customer Service: +255 XXX XXX XXX</p>
                        </div>
                    </div>
                    <!-- Contact Info Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Contact Us End -->

    <!-- Google Map & Contact Form Section Start -->
    <div class="google-map-form">
        <div class="google-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254557.22127429527!2d39.11323235324746!3d-6.792354036717419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4c1fdb6a5b7b%3A0x295368628523bbde!2sDar%20es%20Salaam%2C%20Tanzania!5e0!3m2!1sen!2sus!4v1708637426304!5m2!1sen!2sus" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <!-- Contact Form Box Start -->
                    <div class="contact-form-box">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Request a Quote</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Transform Your Space Today</h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Contact Form Start -->
                        <form id="contactForm" action="#" method="POST" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.5s">
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <select name="product_interest" class="form-control" id="product_interest" required>
                                        <option value="" selected disabled>I'm interested in...</option>
                                        <option value="Security Doors">Security Doors</option>
                                        <option value="Interior Doors">Interior Doors</option>
                                        <option value="Aluminum Windows">Aluminum Windows</option>
                                        <option value="Aluminum Doors">Aluminum Doors</option>
                                        <option value="Other">Other (Please specify)</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-12 mb-5">
                                    <textarea name="message" class="form-control" id="message" rows="4" placeholder="Tell us about your project"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="contact-form-btn">
                                        <button type="submit" class="btn-default">Request Quote</button>
                                        <div id="msgSubmit" class="h3 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Contact Form End -->
                    </div>
                    <!-- Contact Form Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map & Contact Form Section End -->
@endsection
