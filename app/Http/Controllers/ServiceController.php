<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\GarageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->id) {
            return redirect()->route('home')->with('error', 'No garage assigned to your account.');
        }

        $services = Service::where('garage_id', $user->id)->get();
        // dd($services);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(Auth::user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'per_km_charge' => 'nullable|numeric',
        ]);

        // Step 1: Create service
        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Step 2: Link to garage
        GarageService::create([
            'garage_id' => Auth::user()->id, // or use a relation if available
            'service_id' => $service->id,
            'base_price' => $request->base_price,
            'per_km_charge' => $request->per_km_charge,
            'is_available' => true,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
