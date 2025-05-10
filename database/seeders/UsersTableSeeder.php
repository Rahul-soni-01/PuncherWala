<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@puncherwala.test',
            'password' => Hash::make('password'),
            'type' => 'admin',
        ]);

        // Garage owners
        $garageOwners = [
            ['name' => 'Rajesh Auto Care', 'email' => 'rajesh@garage.test'],
            ['name' => 'Mehul Motors', 'email' => 'mehul@garage.test'],
            ['name' => 'City Garage', 'email' => 'city@garage.test'],
        ];

        foreach ($garageOwners as $owner) {
            User::create([
                'name' => $owner['name'],
                'email' => $owner['email'],
                'password' => Hash::make('password'),
                'type' => 'garage_owner',
            ]);
        }

        // Customers
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Customer ' . $i,
                'email' => 'customer' . $i . '@test.com',
                'password' => Hash::make('password'),
                'type' => 'customer',
            ]);
        }
    }
}
