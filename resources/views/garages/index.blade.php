@extends('layouts.app')

@section('content')
<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade mb-5 shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/instant-image-2.png') }}" class="d-block w-100" alt="Service 1" style="height: 400px; object-fit: cover;">
            <div class="carousel-caption text-start p-4" style="background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.3)); border-radius: 0 10px 10px 0;">
                <h3 class="fw-bold text-warning">Instant Puncture Repair</h3>
                <p class="lead">Get back on the road in minutes with Puncherwala.com</p>
                <a href="#" class="btn btn-warning btn-sm">Book Now</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/Service-in-30-Minute.png') }}" class="d-block w-100" alt="Service 2" style="height: 400px; object-fit: cover;">
            <div class="carousel-caption text-end p-4" style="background: linear-gradient(to left, rgba(0,0,0,0.7), rgba(0,0,0,0.3)); border-radius: 10px 0 0 10px;">
                <h3 class="fw-bold text-primary">Service in 30 Minutes</h3>
                <p class="lead">Our verified mechanics reach you fast</p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
    </button>
</div>

<!-- About Us Section -->
<section class="about-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-4">About PuncherWala</h2>
                <p class="lead">Your trusted partner for emergency vehicle services</p>
                <p>Founded in 2023, PuncherWala has revolutionized roadside assistance by connecting vehicle owners with
                    certified mechanics instantly. Our network of professional garages ensures you get quality service
                    wherever you are.</p>
                <p>With over 500 satisfied customers and counting, we're committed to making your vehicle breakdown
                    experience stress-free and efficient.</p>
                <a href="#" class="btn btn-primary mt-3">Learn More</a>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/About-PuncherWala.png') }}" alt="About Us" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Main Content (Your Existing Garage Listing) -->
<div class="container py-4">
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="mb-0">Nearby Garages</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('garages.create') }}" class="btn btn-primary">
                    Register Your Garage
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('garages.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <select name="service" class="form-select">
                                <option value="">All Services</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('service')==$service->id ? 'selected' : ''
                                    }}>
                                    {{ $service->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by name or location" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($garages as $garage)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $garage->name }}</h5>
                        <div class="mb-2 text-muted">
                            <i class="fas fa-map-marker-alt"></i> {{ $garage->address }}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-phone"></i> {{ $garage->contact_number }}
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            {{ number_format($garage->rating, 1) }}
                            <span class="text-muted">({{ $garage->inquiries()->count() }} services)</span>
                        </div>

                        <h6 class="mt-3">Available Services:</h6>
                        <ul class="list-unstyled">
                            @foreach($garage->services as $service)
                            <li class="mb-2">
                                <strong>{{ $service->name }}</strong> -
                                ₹{{ $service->pivot->base_price }}
                                @if($service->pivot->per_km_charge)
                                + ₹{{ $service->pivot->per_km_charge }}/km
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('inquiries.create', ['garage' => $garage->id]) }}"
                            class="btn btn-primary w-100">
                            Request Service
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">No garages found matching your criteria.</div>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $garages->links() }}
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<section class="testimonials py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">What Our Customers Say</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/customer-1.png') }}" class="rounded-circle mb-3" height="100px"
                            alt="Customer">
                        <h5 class="card-title">Rahul Sharma</h5>
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="card-text">"Got my flat tire fixed within 30 minutes at midnight! PuncherWala saved my
                            important business trip."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/customer-2.png') }}" class="rounded-circle mb-3"  height="100px"
                            alt="Customer">
                        <h5 class="card-title">Priya Patel</h5>
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="card-text">"The mechanic arrived with all necessary tools and fixed my car's battery
                            issue on the spot. Highly recommended!"</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/customer-3.png') }}" class="rounded-circle mb-3"  height="100px"
                            alt="Customer">
                        <h5 class="card-title">Vikram Singh</h5>
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="card-text">"Transparent pricing and professional service. I use PuncherWala for all my
                            vehicle maintenance now."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Feedback Form -->
<section class="feedback py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Share Your Feedback</h2>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select class="form-select" id="rating">
                                        <option value="5">Excellent (5 Stars)</option>
                                        <option value="4">Good (4 Stars)</option>
                                        <option value="3">Average (3 Stars)</option>
                                        <option value="2">Below Average (2 Stars)</option>
                                        <option value="1">Poor (1 Star)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Your Feedback</label>
                                    <textarea class="form-control" id="message" rows="4" required></textarea>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary px-4">Submit Feedback</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>PuncherWala</h5>
                <p>Your reliable partner for all vehicle emergency services across the city.</p>
                <div class="social-icons">
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Home</a></li>
                    <li><a href="#" class="text-white">Services</a></li>
                    <li><a href="#" class="text-white">About Us</a></li>
                    <li><a href="#" class="text-white">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Services</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Puncture Repair</a></li>
                    <li><a href="#" class="text-white">Tire Replacement</a></li>
                    <li><a href="#" class="text-white">Battery Service</a></li>
                    <li><a href="#" class="text-white">Towing Service</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> 123 Service Road, Mumbai</li>
                    <li><i class="fas fa-phone me-2"></i> +91 9876543210</li>
                    <li><i class="fas fa-envelope me-2"></i> help@puncherwala.com</li>
                </ul>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; {{date('Y')}} PuncherWala. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">
                    <a href="#" class="text-white me-3">Privacy Policy</a>
                    <a href="#" class="text-white">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

@endsection

@push('styles')
<style>
    .carousel-item {
        height: 400px;
        background-color: #777;
    }

    .carousel-item img {
        object-fit: cover;
        height: 100%;
    }

    .social-icons a {
        display: inline-block;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        text-align: center;
        line-height: 36px;
        margin-right: 8px;
    }

    .social-icons a:hover {
        background: var(--bs-primary);
    }
</style>
@endpush

@push('scripts')
<!-- If you need any custom JavaScript -->
@endpush