<div class="card">
    <div class="card-header bg-primary text-white">
        {{ Auth::user()->garage->name }}
    </div>
    <div class="list-group list-group-flush">
        <a href="{{ route('garage.dashboard') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('garage.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </a>
        <a href="{{ route('garage.bookings') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('garage.bookings') ? 'active' : '' }}">
            <i class="fas fa-calendar-check me-2"></i>Book Service
        </a>
        <a href="{{ route('garage.history') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('garage.history') ? 'active' : '' }}">
            <i class="fas fa-history me-2"></i>Service History
        </a>
        <a href="{{ route('garage.payments') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('garage.payments') ? 'active' : '' }}">
            <i class="fas fa-credit-card me-2"></i>Payment Methods
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-cog me-2"></i>Settings
        </a>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="list-group-item list-group-item-action text-danger">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>