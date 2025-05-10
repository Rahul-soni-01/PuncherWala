@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Request Service from {{ $garage->name }}
                    <a href="{{ route('garages.show', $garage) }}" class="btn btn-sm btn-outline-secondary float-end">
                        Back to Garage
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('inquiries.store') }}">
                        @csrf
                        
                        <input type="hidden" name="garage_id" value="{{ $garage->id }}">
                        
                        <div class="mb-3">
                            <label for="service_id" class="form-label">Service Needed</label>
                            <select name="service_id" id="service_id" class="form-select" required>
                                @foreach($garage->services as $service)
                                    <option value="{{ $service->id }}" 
                                        data-base-price="{{ $service->pivot->base_price }}" 
                                        data-per-km="{{ $service->pivot->per_km_charge ?? 0 }}">
                                        {{ $service->name }} - ₹{{ $service->pivot->base_price }}
                                        @if($service->pivot->per_km_charge)
                                            + ₹{{ $service->pivot->per_km_charge }}/km
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="vehicle_type" class="form-label">Vehicle Type</label>
                            <select name="vehicle_type" id="vehicle_type" class="form-select" required>
                                <option value="bike">Bike</option>
                                <option value="car">Car</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="problem_description" class="form-label">Problem Description</label>
                            <textarea name="problem_description" id="problem_description" 
                                class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Your Location</label>
                            <div id="map" style="height: 300px; border-radius: 8px;"></div>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <small class="text-muted">
                                Please allow location access or drag the marker to your exact location
                            </small>
                        </div>
                        
                        <div class="mb-3 alert alert-info">
                            <strong>Estimated Price:</strong> 
                            ₹<span id="estimated_price">{{ $garage->services->first()->pivot->base_price }}</span>
                            <div id="distance_info" class="small mt-1"></div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let map;
    let marker;

    function initMap() {
        const defaultPos = { 
            lat: {{ $garage->location->getLat() }}, 
            lng: {{ $garage->location->getLng() }} 
        };
        
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: defaultPos,
            mapTypeControl: false,
            streetViewControl: false
        });
        
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: defaultPos,
            title: "Drag to your exact location"
        });
        
        // Try HTML5 geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    
                    marker.setPosition(pos);
                    map.setCenter(pos);
                    updatePositionFields(pos);
                    calculatePrice(pos);
                },
                () => {
                    handleLocationError(true, defaultPos);
                }
            );
        } else {
            handleLocationError(false, defaultPos);
        }
        
        marker.addListener("dragend", () => {
            const pos = marker.getPosition();
            updatePositionFields({ lat: pos.lat(), lng: pos.lng() });
            calculatePrice({ lat: pos.lat(), lng: pos.lng() });
        });
    }
    
    function updatePositionFields(pos) {
        document.getElementById('latitude').value = pos.lat;
        document.getElementById('longitude').value = pos.lng;
    }
    
    function calculatePrice(customerPos) {
        const garagePos = {
            lat: {{ $garage->location->getLat() }},
            lng: {{ $garage->location->getLng() }}
        };
        
        const serviceSelect = document.getElementById('service_id');
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const basePrice = parseFloat(selectedOption.dataset.basePrice);
        const perKmCharge = parseFloat(selectedOption.dataset.perKm) || 0;
        
        const distance = calculateDistance(
            customerPos.lat, customerPos.lng,
            garagePos.lat, garagePos.lng
        );
        
        let totalPrice = basePrice;
        let distanceInfo = '';
        
        if (perKmCharge > 0) {
            totalPrice += (distance * perKmCharge);
            distanceInfo = `Distance: ${distance.toFixed(2)} km × ₹${perKmCharge}/km`;
        }
        
        document.getElementById('estimated_price').textContent = totalPrice.toFixed(2);
        document.getElementById('distance_info').innerHTML = distanceInfo;
    }
    
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth radius in km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c; // Distance in km
    }
    
    function handleLocationError(browserHasGeolocation, pos) {
        marker.setPosition(pos);
        map.setCenter(pos);
        updatePositionFields(pos);
        calculatePrice(pos);
    }
    
    document.getElementById('service_id').addEventListener('change', function() {
        const pos = {
            lat: parseFloat(document.getElementById('latitude').value || {{ $garage->location->getLat() }}),
            lng: parseFloat(document.getElementById('longitude').value || {{ $garage->location->getLng() }})
        };
        calculatePrice(pos);
    });
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap"></script>
@endpush
@endsection