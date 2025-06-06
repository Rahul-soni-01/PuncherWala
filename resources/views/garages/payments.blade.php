@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            @include('garage.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Payment History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                <tr>
                                    <td>#{{ $payment->id }}</td>
                                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                                    <td>{{ $payment->customer->name }}</td>
                                    <td>{{ $payment->service->name }}</td>
                                    <td>₹{{ $payment->payment->amount }}</td>
                                    <td>{{ ucfirst($payment->payment->payment_method) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $payment->payment->status == 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($payment->payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No payment records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $payments->links() }}

                    <div class="mt-5">
                        <h5>Payment Summary</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Total Earnings</h6>
                                        <h3 class="text-primary">₹{{ number_format($totalEarnings, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Completed Payments</h6>
                                        <h3 class="text-success">{{ $completedPayments }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-warning">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Pending Payments</h6>
                                        <h3 class="text-warning">{{ $pendingPayments }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection