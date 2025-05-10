@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Banner -->
    <div class="bg-primary text-white py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="mb-0">Ready to get your vehicle services?</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-white text-primary fs-6 p-2">Premium Member</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="container mt-4">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-tools fs-1 text-primary"></i>
                        <h5 class="mt-2">Book Service</h5>
                        <a href="{{ route('services.create') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history fs-1 text-warning"></i>
                        <h5 class="mt-2">Service History</h5>
                        <a href="{{ route('services.history') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-geo-alt fs-1 text-success"></i>
                        <h5 class="mt-2">Track Mechanic</h5>
                        <a href="{{ route('tracking.current') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-credit-card fs-1 text-info"></i>
                        <h5 class="mt-2">Payment Methods</h5>
                        <a href="{{ route('payment.methods') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Service Status -->
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">Current Service Status</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle p-3">
                            <i class="bi bi-wrench fs-1 text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-4">
                        <h5>Puncture Repair</h5>
                        <div class="progress mt-2" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted">Estimated completion: 15 min</span>
                            <span class="fw-bold">Mechanic en route</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Services -->
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Recent Services</h5>
                <a href="{{ route('services.history') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Service ID</th>
                                <th>Service Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#PW-12548</td>
                                <td>Tire Replacement</td>
                                <td>May 15, 2023</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>₹850</td>
                                <td><a href="#" class="btn btn-sm btn-outline-secondary">Details</a></td>
                            </tr>
                            <tr>
                                <td>#PW-11932</td>
                                <td>Puncture Repair</td>
                                <td>May 5, 2023</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>₹250</td>
                                <td><a href="#" class="btn btn-sm btn-outline-secondary">Details</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Section -->
    <div class="container mt-5 mb-5">
        <div class="card border-danger shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0 fw-bold">Emergency Services</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-telephone-fill text-danger me-2"></i> Immediate Assistance</h6>
                        <p>Contact our 24/7 support for urgent vehicle issues</p>
                        <a href="tel:+911234567890" class="btn btn-danger">
                            <i class="bi bi-telephone me-2"></i> Call Now: +91 1234567890
                        </a>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-geo-alt-fill text-danger me-2"></i> Nearest Service Center</h6>
                        <p>PuncherWala Center, MG Road, Bangalore</p>
                        <a href="#" class="btn btn-outline-danger">
                            <i class="bi bi-map me-2"></i> Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection