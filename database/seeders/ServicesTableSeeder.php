<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            Service::create($service);
        }
    }
}
