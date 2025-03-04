@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 mb-3 brand-primary">Contact Us</h1>
            <p class="lead mx-auto" style="max-width: 700px; color: var(--text-color);">We'd love to hear from you! Please fill out the form below or use our contact information to get in touch with our team.</p>
        </div>

        <div class="row">
            <!-- Contact Information -->
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="card shadow h-100 border-0 rounded-lg">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-4 brand-primary border-bottom pb-2">
                            <i class="fas fa-address-card mr-2"></i> Contact Information
                        </h2>

                        <div class="media mb-4">
                            <div class="mr-3 bg-brand-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--accent-color);">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 h5 font-weight-bold" style="color: var(--accent-color);">Our Location</h5>
                                <p style="color: var(--text-color);" class="mb-0">Mikocheni A, 51 Mwai Kibaki Rd<br>Dar es Salaam 1411, Tanzania</p>
                            </div>
                        </div>

                        <div class="media mb-4">
                            <div class="mr-3 bg-brand-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--accent-color);">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 h5 font-weight-bold" style="color: var(--accent-color);">Phone</h5>
                                <p style="color: var(--text-color);" class="mb-0">
                                    <a href="tel:+255676111700" style="color: var(--text-color);">+255 676 111 700</a>
                                </p>
                            </div>
                        </div>

                        <div class="media mb-4">
                            <div class="mr-3 bg-brand-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--accent-color);">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 h5 font-weight-bold" style="color: var(--accent-color);">Email</h5>
                                <p style="color: var(--text-color);" class="mb-0">
                                    <a href="mailto:info@simbadw.co.tz" style="color: var(--text-color);">info@simbadw.co.tz</a>
                                </p>
                            </div>
                        </div>

                        <div class="media mb-4">
                            <div class="mr-3 bg-brand-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--accent-color);">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 h5 font-weight-bold" style="color: var(--accent-color);">Business Hours</h5>
                                <p style="color: var(--text-color);" class="mb-0">
                                    Monday - Friday: 8:00 AM - 5:00 PM<br>
                                    Saturday: 9:00 AM - 1:00 PM<br>
                                    Sunday: Closed
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <a href="#" class="btn brand-btn-primary btn-lg mb-3">
                                <i class="fas fa-download mr-2"></i> Download Brochure
                            </a>
                        </div>

                        <div class="mt-4">
                            <h5 class="h5 font-weight-bold mb-3" style="color: var(--accent-color);">Connect With Us</h5>
                            <div>
                                <a href="#" class="btn brand-btn-secondary mr-2 mb-2 rounded-circle shadow-sm" style="width: 45px; height: 45px;">
                                    <i class="fab fa-facebook-f" style="color: var(--accent-color);"></i>
                                </a>
                                <a href="#" class="btn brand-btn-secondary mr-2 mb-2 rounded-circle shadow-sm" style="width: 45px; height: 45px;">
                                    <i class="fab fa-twitter" style="color: var(--accent-color);"></i>
                                </a>
                                <a href="#" class="btn brand-btn-secondary mr-2 mb-2 rounded-circle shadow-sm" style="width: 45px; height: 45px;">
                                    <i class="fab fa-instagram" style="color: var(--accent-color);"></i>
                                </a>
                                <a href="#" class="btn brand-btn-secondary mr-2 mb-2 rounded-circle shadow-sm" style="width: 45px; height: 45px;">
                                    <i class="fab fa-linkedin-in" style="color: var(--accent-color);"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form and Map -->
            <div class="col-lg-7">
                <div class="card shadow border-0 rounded-lg mb-4">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-4 brand-primary border-bottom pb-2">
                            <i class="fas fa-paper-plane mr-2"></i> Send Us a Message
                        </h2>

                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold" style="color: var(--accent-color);">Your Name</label>
                                        <input type="text" id="name" name="name" class="form-control form-control-lg brand-form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="font-weight-bold" style="color: var(--accent-color);">Your Email</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg brand-form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subject" class="font-weight-bold" style="color: var(--accent-color);">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control form-control-lg brand-form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="message" class="font-weight-bold" style="color: var(--accent-color);">Your Message</label>
                                <textarea id="message" name="message" class="form-control form-control-lg brand-form-control" rows="5" required></textarea>
                            </div>

                            <button type="submit" class="btn brand-btn-primary btn-lg px-4">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Map -->
                <div class="card shadow border-0 rounded-lg">
                    <div class="card-body p-0">
                        <h2 class="h4 mb-0 brand-primary p-4 border-bottom">
                            <i class="fas fa-map-marked-alt mr-2"></i> Our Location
                        </h2>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.7985782717567!2d39.27211007595545!3d-6.7915697180932786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4c7f7ee1bd79%3A0xdc63e6c8a6bc82c!2s51%20Mwai%20Kibaki%20Rd%2C%20Dar%20es%20Salaam%2C%20Tanzania!5e0!3m2!1sen!2sus!4v1709569923548!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #deaf33;
            --secondary-color: #F1EFF0;
            --text-color: #474749;
            --accent-color: #1e1e1e;
            --white-color: #FFFFFF;
            --divider-color: rgba(20, 24, 62, 0.06);
        }

        /* Override Bootstrap text-primary class */
        .text-primary {
            color: var(--primary-color) !important;
        }

        /* Create custom brand color classes to avoid conflicts */
        .brand-primary {
            color: var(--primary-color) !important;
        }

        .bg-brand-primary {
            background-color: var(--primary-color) !important;
        }

        .brand-btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: var(--accent-color) !important;
            font-weight: 600 !important;
        }

        .brand-btn-primary:hover {
            background-color: #c99c2d !important;
            border-color: #c99c2d !important;
        }

        .brand-btn-secondary {
            background-color: var(--secondary-color) !important;
            border-color: var(--secondary-color) !important;
        }

        /* Form control custom styling */
        .brand-form-control {
            border-color: var(--secondary-color) !important;
        }

        .brand-form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(222, 175, 51, 0.25) !important;
        }

        /* Remove any lingering blue color */
        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: var(--accent-color) !important;
        }

        .btn-primary:hover {
            background-color: #c99c2d !important;
            border-color: #c99c2d !important;
        }

        a {
            color: var(--primary-color) !important;
        }

        a:hover {
            color: #c99c2d !important;
        }

        .card {
            transition: transform 0.3s;
            background-color: var(--white-color);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .rounded-lg {
            border-radius: 0.5rem !important;
        }

        .shadow {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
        }

        .border-bottom {
            border-bottom-color: var(--divider-color) !important;
        }
    </style>
@endsection
