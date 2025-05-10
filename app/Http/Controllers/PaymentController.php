<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request, Payment $payment)
    {
        if ($payment->inquiry->customer_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:card,upi,cash'
        ]);

        // For online payments
        if ($validated['payment_method'] !== 'cash') {
            // Process payment via Stripe/Razorpay
            try {
                $charge = $this->processOnlinePayment($payment, $validated['payment_method']);

                $payment->update([
                    'payment_method' => $validated['payment_method'],
                    'transaction_id' => $charge->id,
                    'status' => 'completed'
                ]);

                return response()->json(['message' => 'Payment successful']);
            } catch (\Exception $e) {
                $payment->update(['status' => 'failed']);
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }

        // For cash payments
        $payment->update([
            'payment_method' => 'cash',
            'status' => 'completed'
        ]);

        return response()->json(['message' => 'Payment will be collected in cash']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
