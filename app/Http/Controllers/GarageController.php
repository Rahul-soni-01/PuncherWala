<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Models\Service;
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
}
