@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            @include('garage.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Track Service Request #{{ $booking->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6>Customer Details</h6>
                                <p>
                                    <strong>Name:</strong> {{ $booking->customer->name }}<br>
                                    <strong>Contact:</strong> {{ $booking->customer->phone ?? 'N/A' }}<br>
                                    <strong>Vehicle:</strong> {{ ucfirst($booking->vehicle_type) }}<br>
                                    <strong>Issue:</strong> {{ $booking->problem_description }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <h6>Service Details</h6>
                                <p>
                                    <strong>Service:</strong> {{ $booking->service->name }}<br>
                                    <strong>Price:</strong> ₹{{ $booking->estimated_price }}<br>
                                    <strong>Status:</strong> 
                                    <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </p>
                            </div>
                            
                            @if($booking->status == 'accepted')
                            <div class="mb-4">
                                <h6>Mechanic Details</h6>
                                <p>
                                    <strong>Name:</strong> {{ $booking->mechanic->name }}<br>
                                    <strong>ETA:</strong> {{ $booking->estimated_time }}<br>
                                    <strong>Contact:</strong> {{ $booking->mechanic->phone }}
                                </p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <div id="map" style="height: 400px; border-radius: 8px;"></div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Service Progress</h6>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                role="progressbar" style="width: {{ $booking->status == 'completed' ? '100' : ($booking->status == 'accepted' ? '50' : '10') }}%">
                                {{ ucfirst($booking->status) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function initMap() {
        const customerLocation = { 
            lat: {{ $booking->latitude }}, 
            lng: {{ $booking->longitude }} 
        };
        const mechanicLocation = { 
            lat: {{ $mechanicLocation['lat'] }}, 
            lng: {{ $mechanicLocation['lng'] }} 
        };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: customerLocation,
        });
        
        new google.maps.Marker({
            position: customerLocation,
            map,
            title: "Customer Location",
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
            }
        });
        
        new google.maps.Marker({
            position: mechanicLocation,
            map,
            title: "Mechanic Location",
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap"></script>
@endpush
@endsection