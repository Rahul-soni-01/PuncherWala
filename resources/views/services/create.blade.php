@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>Add New Service
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Oops!</strong> Please fix the following issues:<br><br>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Service Name</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="base_price" class="form-label">Base Price (₹)</label>
                            <input type="number" step="0.01" name="base_price" class="form-control" required value="{{ old('base_price') }}">
                        </div>

                        <div class="mb-3">
                            <label for="per_km_charge" class="form-label">Per KM Charge (₹)</label>
                            <input type="number" step="0.01" name="per_km_charge" class="form-control" value="{{ old('per_km_charge') }}">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_available" class="form-check-input" id="is_available" checked>
                            <label class="form-check-label" for="is_available">Service is currently available</label>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Save Service
                        </button>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
