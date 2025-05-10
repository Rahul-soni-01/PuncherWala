<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Garage;
use App\Models\Service;

class GarageServicesTableSeeder extends Seeder
{
    public function run()
    {
        $garages = Garage::all();
        $services = Service::all();

        foreach ($garages as $garage) {
            foreach ($services as $service) {
                // Randomly decide if garage offers this service (80% chance)
                if (rand(1, 100) <= 80) {
                    $garage->services()->attach($service->id, [
                        'base_price' => $this->getBasePrice($service->name),
                        'per_km_charge' => $this->getPerKmCharge($service->name),
                        'is_available' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    private function getBasePrice($serviceName)
    {
        return match($serviceName) {
            'Puncture Repair' => rand(100, 300),
            'Tire Replacement' => rand(500, 2000),
            'Battery Service' => rand(200, 800),
            'Car Wash' => rand(150, 600),
            'Oil Change' => rand(400, 1200),
            'Towing Service' => rand(800, 2500),
            'Emergency Fuel' => rand(100, 300),
            'AC Repair' => rand(500, 1500),
            default => rand(200, 1000),
        };
    }

    private function getPerKmCharge($serviceName)
    {
        // Only some services charge per km
        return in_array($serviceName, ['Towing Service', 'Emergency Fuel']) 
            ? rand(20, 50) 
            : null;
    }
}
