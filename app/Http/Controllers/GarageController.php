<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Models\Service;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GarageController extends Controller
{
    public function index()
    {
        $query = Garage::with('services');

        // Filter by service
        if (request()->has('service')) {
            $query->whereHas('services', function ($q) {
                $q->where('services.id', request('service'));
            });
        }

        // Search by name or address
        if (request()->has('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $garages = $query->paginate(10);
        $services = Service::all();

        return view('garages.index', compact('garages', 'services'));
    }

    public function create()
    {
        $services = Service::all();
        return view('garages.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.base_price' => 'required|numeric|min:0',
            'services.*.per_km_charge' => 'nullable|numeric|min:0'
        ]);

        $garage = Garage::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'contact_number' => $validated['contact_number'],
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $validated['address'],
            'opening_time' => $validated['opening_time'],
            'closing_time' => $validated['closing_time'],
            'is_24_7' => $request->has('is_24_7')
        ]);

        foreach ($validated['services'] as $service) {
            $garage->services()->attach($service['id'], [
                'base_price' => $service['base_price'],
                'per_km_charge' => $service['per_km_charge'] ?? null,
                'is_available' => true
            ]);
        }

        return redirect()->route('garages.show', $garage)
            ->with('success', 'Garage registered successfully!');
    }

    public function show(Garage $garage)
    {
        return view('garages.show', compact('garage'));
    }

    // Add other methods (edit, update, destroy) as needed
     public function dashboard()
    {
        $garage = Auth::user()->garage;
        
        return view('garage.dashboard', [
            'pendingCount' => Inquiry::where('garage_id', $garage->id)
                                ->where('status', 'pending')
                                ->count(),
            'completedCount' => Inquiry::where('garage_id', $garage->id)
                                ->where('status', 'completed')
                                ->count(),
            'recentBookings' => Inquiry::with(['customer', 'service'])
                                ->where('garage_id', $garage->id)
                                ->latest()
                                ->take(5)
                                ->get()
        ]);
    }

    public function bookings()
    {
        $garage = Auth::user()->garage;
        
        $bookings = Inquiry::with(['customer', 'service'])
                    ->where('garage_id', $garage->id)
                    ->where('status', 'pending')
                    ->latest()
                    ->paginate(10);
        
        return view('garage.bookings', compact('bookings'));
    }

    public function history()
    {
        $garage = Auth::user()->garage;
        
        $history = Inquiry::with(['customer', 'service', 'payment'])
                    ->where('garage_id', $garage->id)
                    ->whereIn('status', ['completed', 'cancelled'])
                    ->latest()
                    ->paginate(10);
        
        return view('garage.history', compact('history'));
    }

    public function track(Inquiry $inquiry)
    {
        $this->authorize('view', $inquiry);
        
        return view('garage.track', [
            'booking' => $inquiry->load(['customer', 'service', 'payment']),
            'mechanicLocation' => $this->getMechanicLocation($inquiry)
        ]);
    }

    public function payments()
    {
        $garage = Auth::user()->garage;
        
        $payments = Inquiry::with(['customer', 'service', 'payment'])
                    ->where('garage_id', $garage->id)
                    ->whereHas('payment')
                    ->latest()
                    ->paginate(10);
        
        return view('garage.payments', compact('payments'));
    }

    public function acceptBooking(Request $request, Inquiry $inquiry)
    {
        $this->authorize('update', $inquiry);
        
        $validated = $request->validate([
            'mechanic_id' => 'required|exists:users,id',
            'estimated_time' => 'required|date_format:H:i'
        ]);
        
        $inquiry->update([
            'status' => 'accepted',
            'mechanic_id' => $validated['mechanic_id'],
            'estimated_time' => $validated['estimated_time']
        ]);
        
        return redirect()->route('garage.track', $inquiry)
            ->with('success', 'Booking accepted successfully!');
    }

    private function getMechanicLocation($inquiry)
    {
        // Implement real-time tracking logic here
        // This is a placeholder - integrate with Google Maps or Mapbox
        return [ 'lat' => $inquiry->latitude + (rand(-10, 10) * 0.001), 'lng' => $inquiry->longitude + (rand(-10, 10) * 0.001 )];
    }
}
