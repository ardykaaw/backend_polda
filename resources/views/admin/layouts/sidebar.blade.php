<div class="sidebar">
    <!-- Logo Section -->
    <div class="p-4 text-center">
        <img src="{{ asset('logo.png') }}" alt="Logo Polda" class="w-20 mx-auto mb-2">
        <h1 class="text-sm font-bold text-gray-800 tracking-wide">MONITORING</h1>
        <h2 class="text-sm font-bold text-gray-800 tracking-wide">DITLANTAS</h2>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-4">
        <a href="{{ route('admin.dashboard') }}" 
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.attendance') }}" 
           class="nav-link {{ request()->routeIs('admin.attendance') ? 'active' : '' }}">
            <i class="fas fa-clock"></i>
            <span>Kehadiran</span>
        </a>
        <a href="{{ route('admin.users') }}"
           class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
        
    </nav>

    <!-- Logout Button -->
    <div class="absolute bottom-4 w-full px-4">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg flex items-center justify-center transition duration-150">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>
</div>
