<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class InquiryController extends Controller
{
    public function create(Garage $garage)
    {
        return view('inquiries.create', compact('garage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'service_id' => 'required|exists:services,id',
            'vehicle_type' => 'required|in:bike,car',
            'problem_description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $garage = Garage::with(['services' => fn($q) => $q->where('services.id', $validated['service_id'])])
            ->findOrFail($validated['garage_id']);

        $distance = $this->calculateDistance(
            $garage->location->getLat(),
            $garage->location->getLng(),
            $validated['latitude'],
            $validated['longitude']
        );

        $service = $garage->services->first();
        $price = $service->pivot->base_price;

        if ($service->pivot->per_km_charge) {
            $price += $distance * $service->pivot->per_km_charge;
        }

        $inquiry = Inquiry::create([
            'customer_id' => Auth::id(),
            'garage_id' => $validated['garage_id'],
            'service_id' => $validated['service_id'],
            'vehicle_type' => $validated['vehicle_type'],
            'problem_description' => $validated['problem_description'],
            'location' => DB::raw("POINT({$validated['latitude']}, {$validated['longitude']})"),
            'distance_km' => $distance,
            'estimated_price' => $price,
            'status' => 'pending'
        ]);

        return redirect()->route('inquiries.show', $inquiry)
            ->with('success', 'Service request submitted successfully!');
    }

    public function show(Inquiry $inquiry)
    {
        return view('inquiries.show', compact('inquiry'));
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        return $dist * 60 * 1.1515 * 1.609344; // Convert to km
    }
}
