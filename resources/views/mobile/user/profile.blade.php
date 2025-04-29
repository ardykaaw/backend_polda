@extends('mobile.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Profile Header -->
    <div class="bg-blue-900 pt-6 pb-24 relative">
        <div class="container mx-auto px-4">
            <!-- Profile Image -->
            <div class="relative w-24 h-24 mx-auto mb-4">
                <div class="w-full h-full rounded-full bg-white border-4 border-white overflow-hidden">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                             alt="Profile" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <i class="fas fa-user text-3xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                <label for="profile-photo" class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg cursor-pointer">
                    <i class="fas fa-camera text-blue-900"></i>
                </label>
                <input type="file" 
                       id="profile-photo" 
                       accept="image/*" 
                       class="hidden"
                       onchange="handleProfilePhotoChange(this)">
            </div>

            <!-- User Name -->
            <div class="text-center text-white">
                <h1 class="text-xl font-bold">
                    {{ auth()->user()->pangkat }} {{ auth()->user()->nama }}
                </h1>
                <p class="text-sm opacity-90">{{ auth()->user()->nrp }}</p>
            </div>
        </div>
    </div>

    <!-- Profile Info Card -->
    <div class="container mx-auto px-4 -mt-16">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-6">Informasi Profil</h2>
            
            <div class="space-y-4">
                <!-- NRP -->
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-id-card text-blue-900 w-6"></i>
                        <span class="ml-3 text-gray-600">NRP</span>
                    </div>
                    <span class="font-medium">{{ auth()->user()->nrp }}</span>
                </div>

                <!-- Pangkat -->
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-star text-blue-900 w-6"></i>
                        <span class="ml-3 text-gray-600">Pangkat</span>
                    </div>
                    <span class="font-medium">{{ auth()->user()->pangkat }}</span>
                </div>

                <!-- Divisi -->
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-users text-blue-900 w-6"></i>
                        <span class="ml-3 text-gray-600">Divisi</span>
                    </div>
                    <span class="font-medium">{{ auth()->user()->divisi }}</span>
                </div>

                <!-- Status -->
                <div class="flex justify-between items-center py-3">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-blue-900 w-6"></i>
                        <span class="ml-3 text-gray-600">Status</span>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="mt-6 px-4">
            <form action="{{ route('mobile.logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="w-full bg-red-500 text-white py-3 rounded-xl flex items-center justify-center">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function handleProfilePhotoChange(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Create FormData
        const formData = new FormData();
        formData.append('photo', file);

        try {
            const response = await fetch('{{ route("mobile.profile.update-photo") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Network response was not ok');
            }
            
            const data = await response.json();
            if (data.success) {
                location.reload();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            alert('Error updating profile photo: ' + error.message);
            console.error('Error:', error);
        }
    }
}
</script>
@endpush
@endsection
