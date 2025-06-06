<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Garage;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $garage = Garage::first();

        if (!$garage) {
            $this->command->error('No garage found. Please seed garages first.');
            return;
        }

        $services = [
            ['name' => 'Puncture Repair', 'description' => 'Tire puncture fixing service'],
            ['name' => 'Tire Replacement', 'description' => 'Complete tire change service'],
            ['name' => 'Battery Service', 'description' => 'Battery jumpstart and replacement'],
            ['name' => 'Car Wash', 'description' => 'Interior and exterior cleaning'],
            ['name' => 'Oil Change', 'description' => 'Engine oil and filter change'],
            ['name' => 'Towing Service', 'description' => 'Vehicle towing to nearest garage'],
            ['name' => 'Emergency Fuel', 'description' => 'Petrol/Diesel delivery'],
            ['name' => 'AC Repair', 'description' => 'Air conditioning services'],
        ];

        foreach ($services as $service) {
            Service::create([
                'garage_id' => $garage->id,
                'name' => $service['name'],
                'description' => $service['description'],
                'base_price' => rand(100, 500), // or fixed base_price
                'per_km_charge' => rand(5, 20), // optional
                'is_available' => true,
            ]);
        }

        $this->command->info('Services seeded successfully for garage ID: ' . $garage->id);

    }
}
