@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Garage Menu
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('garage.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('garage.bookings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check me-2"></i>Book Service
                    </a>
                    <a href="{{ route('garage.history') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-history me-2"></i>Service History
                    </a>
                    <a href="{{ route('garage.payments') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-credit-card me-2"></i>Payment Methods
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Garage Dashboard</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Pending Bookings</h6>
                                    <h2 class="text-primary">{{ $pendingCount }}</h2>
                                    <a href="{{ route('garage.bookings') }}" class="btn btn-sm btn-primary">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Completed Services</h6>
                                    <h2 class="text-success">{{ $completedCount }}</h2>
                                    <a href="{{ route('garage.history') }}" class="btn btn-sm btn-success">View History</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Recent Bookings</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->customer->name }}</td>
                                    <td>{{ $booking->service->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : 'success' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('garage.track', $booking) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No recent bookings found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection