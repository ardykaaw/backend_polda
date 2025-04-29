@extends('mobile.layouts.app')

@section('content')
<div class="min-h-screen flex flex-col bg-white">
    <div class="flex-1 flex flex-col justify-center px-6 py-12">
        <div class="flex flex-col items-center mb-12">
            <div class="flex justify-center items-center gap-4 mb-6">
                <img src="{{ asset('logo.png') }}" alt="Logo Ditlantas" class="w-40 h-40 object-contain">
            </div>
            <h2 class="text-2xl font-bold text-blue-900">POLDA SULTRA</h2>
        </div>

        <form method="POST" action="{{ route('mobile.authenticate') }}" class="space-y-6 w-full max-w-md mx-auto" id="loginForm">
            @csrf
            <div>
                <label for="nrp" class="sr-only">NRP</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input id="nrp" name="nrp" type="text" required
                           class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                  placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="NRP">
                </div>
            </div>

            <div>
                <label for="password" class="sr-only">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="password" name="password" type="password" required
                           class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                  placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Password">
                </div>
            </div>

            @if ($errors->any())
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg
                           shadow-sm text-sm font-medium text-white bg-blue-900 hover:bg-blue-800
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Masuk
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                nrp: document.getElementById('nrp').value,
                password: document.getElementById('password').value
            })
        });

        const data = await response.json();

        if (response.ok) {
            // Redirect ke dashboard setelah login berhasil
            window.location.href = "{{ route('mobile.dashboard') }}";
        } else {
            // Tampilkan pesan error
            const errorDiv = document.querySelector('.text-red-700');
            if (errorDiv) {
                errorDiv.textContent = data.message || 'Login gagal';
            }
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

// Check if app is in standalone mode and already logged in
if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
    if (document.cookie.includes('logged_in=true')) {
        window.location.href = "{{ route('mobile.dashboard') }}";
    }
}
</script>
@endpush
@endsection
