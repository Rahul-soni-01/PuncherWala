<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Example data - replace with your actual data fetching logic
        $recentServices = [
            [
                'id' => 'PW-12548',
                'type' => 'Tire Replacement',
                'date' => 'May 15, 2023',
                'status' => 'Completed',
                'amount' => '₹850'
            ],
            [
                'id' => 'PW-11932',
                'type' => 'Puncture Repair',
                'date' => 'May 5, 2023',
                'status' => 'Completed',
                'amount' => '₹250'
            ]
        ];

        return view('home', [
            'recentServices' => $recentServices
        ]);
    }
}
