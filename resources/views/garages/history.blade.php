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
                    <h5 class="mb-0">Service History</h5>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $record)
                                <tr>
                                    <td>#{{ $record->id }}</td>
                                    <td>{{ $record->created_at->format('d M Y') }}</td>
                                    <td>{{ $record->customer->name }}</td>
                                    <td>{{ $record->service->name }}</td>
                                    <td>₹{{ $record->estimated_price }}</td>
                                    <td>
                                        <span class="badge bg-{{ $record->status == 'completed' ? 'success' : 'danger' }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('garage.track', $record) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No service history found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $history->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection