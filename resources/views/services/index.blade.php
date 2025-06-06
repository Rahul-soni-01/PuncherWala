@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="bg-primary text-white py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-1">Your Services</h1>
                    <p class="mb-0">Manage all your listed services here</p>
                </div>
                <div>
                    <a href="{{ route('services.create') }}" class="btn btn-light text-primary fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> Add New Service
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Services List -->
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Available Services</h5>
                <span class="text-muted">Total: {{ $services->count() }}</span>
            </div>
            <div class="card-body">
                @if($services->isEmpty())
                    <p class="text-muted">No services found. <a href="{{ route('services.create') }}">Click here</a> to add your first service.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service Name</th>
                                    <th>Description</th>
                                    <th>Base Price</th>
                                    <th>Per KM Charge</th>
                                    <th>Available</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $key => $service)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $service->service->name }}</td>
                                        <td>{{ Str::limit($service->service->description, 40) }}</td>
                                        <td>₹{{ number_format($service->base_price, 2) }}</td>
                                        <td>
                                            @if($service->per_km_charge)
                                                ₹{{ number_format($service->per_km_charge, 2) }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->is_available)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
