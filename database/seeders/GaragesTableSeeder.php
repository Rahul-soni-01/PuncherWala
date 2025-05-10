<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Garage;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class GaragesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $garages = [
            [
                'user_id' => User::where('email', 'rajesh@garage.test')->first()->id,
                'name' => 'Rajesh Auto Care',
                'contact_number' => '9876543210',
                'address' => '123 MG Road, Mumbai',
                'opening_time' => '08:00:00',
                'closing_time' => '20:00:00',
                'is_24_7' => false,
                'latitude' => 19.0760,
                'longitude' => 72.8777,
            ],
            [
                'user_id' => User::where('email', 'mehul@garage.test')->first()->id,
                'name' => 'Mehul Motors',
                'contact_number' => '8765432109',
                'address' => '456 Andheri East, Mumbai',
                'opening_time' => '09:00:00',
                'closing_time' => '21:00:00',
                'is_24_7' => false,
                'latitude' => 19.1136,
                'longitude' => 72.8697,
            ],
            [
                'user_id' => User::where('email', 'city@garage.test')->first()->id,
                'name' => 'City Garage',
                'contact_number' => '7654321098',
                'address' => '789 Bandra West, Mumbai',
                'opening_time' => '00:00:00',
                'closing_time' => '23:59:59',
                'is_24_7' => true,
                'latitude' => 19.0556,
                'longitude' => 72.8351,
            ],
        ];

        foreach ($garages as $garage) {
            DB::table('garages')->insert([
                ...$garage,
                'location' => DB::raw("POINT({$garage['longitude']}, {$garage['latitude']})"),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
