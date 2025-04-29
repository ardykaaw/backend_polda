@extends('mobile.layouts.app')

@section('content')
<div class="bg-blue-900 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="text-center mb-8">
                <img src="{{ asset('logo_polda.png') }}" 
                     alt="Logo Polda" 
                     class="w-32 h-32 mx-auto mb-4 object-contain">
                <h1 class="text-2xl font-bold text-gray-800">Absen DitLantas</h1>
                <p class="text-sm text-gray-600 mt-1">Aplikasi Absensi DitLantas Polda Sultra</p>
                <p class="text-gray-600 mt-2">Install aplikasi untuk pengalaman yang lebih baik</p>
            </div>

            <div class="space-y-4">
                <div class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Akses lebih cepat</span>
                </div>
                <div class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Absensi lebih mudah</span>
                </div>
                <div class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Bekerja secara offline</span>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                <button id="installButton" class="install-button w-full bg-blue-900 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-800 transition-colors">
                    Install Aplikasi
                </button>
                
                <a href="{{ route('mobile.login') }}" class="block text-center w-full bg-gray-100 text-gray-800 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                    Kembali ke Aplikasi
                </a>
            </div>

            <div id="installInstructions" class="mt-6 text-sm text-gray-600">
                <p class="font-medium mb-2">Cara Install di iOS:</p>
                <ol class="list-decimal pl-5 space-y-1">
                    <li>Buka Safari</li>
                    <li>Ketuk tombol Share (ikon kotak dengan panah ke atas)</li>
                    <li>Pilih 'Add to Home Screen'</li>
                    <li>Ketuk 'Add'</li>
                </ol>
            </div>

            @if(Str::contains(request()->userAgent(), ['iPad', 'iPhone', 'iPod']))
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="font-medium text-blue-900 mb-2">Cara Install di iPhone:</h3>
                <ol class="list-decimal pl-5 space-y-2 text-blue-800">
                    <li>Pilih 'Add to Home Screen'</li>
                    <li>Ketuk 'Add'</li>
                </ol>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .install-button {
        display: none;
    }
    
    @media all and (display-mode: browser) {
        .install-button {
            display: block;
        }
    }
</style>

@push('scripts')
<script>
    let deferredPrompt;
    const installButton = document.getElementById('installButton');
    const installInstructions = document.getElementById('installInstructions');

    // Cek apakah PWA sudah terinstall
    const isPWAInstalled = () => {
        return window.matchMedia('(display-mode: standalone)').matches ||
               window.navigator.standalone === true;
    };

    // Debug function
    const debugPWA = () => {
        console.log('Debug PWA Status:');
        console.log('Protocol:', window.location.protocol);
        console.log('Service Worker Support:', 'serviceWorker' in navigator);
        console.log('Display Mode:', window.matchMedia('(display-mode: standalone)').matches);
        console.log('iOS:', /iPad|iPhone|iPod/.test(navigator.userAgent));
        console.log('User Agent:', navigator.userAgent);
    };

    debugPWA();

    // Fungsi untuk mengecek kriteria installable
    const checkInstallable = async () => {
        if (isPWAInstalled()) {
            console.log('PWA sudah terinstall');
            installButton.style.display = 'none';
            return false;
        }

        if (!('serviceWorker' in navigator)) {
            console.error('Service Worker tidak didukung');
            return false;
        }

        try {
            const registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker terdaftar:', registration.scope);
            return true;
        } catch (error) {
            console.error('Gagal mendaftarkan Service Worker:', error);
            return false;
        }
    };

    // Inisialisasi
    window.addEventListener('load', async () => {
        await checkInstallable();
    });

    // Tangkap event beforeinstallprompt
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        
        if (!isPWAInstalled()) {
            installButton.style.display = 'block';
        }
    });

    // Handle tombol install
    installButton.addEventListener('click', async () => {
        if (!deferredPrompt) {
            if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                installInstructions.style.display = 'block';
                installButton.style.display = 'none';
            }
            return;
        }

        try {
            const result = await deferredPrompt.prompt();
            const choiceResult = await deferredPrompt.userChoice;
            
            if (choiceResult.outcome === 'accepted') {
                console.log('Aplikasi berhasil diinstall');
            }
            
            deferredPrompt = null;
            installButton.style.display = 'none';
            
        } catch (error) {
            console.error('Error saat instalasi:', error);
        }
    });

    // Deteksi successful installation
    window.addEventListener('appinstalled', (evt) => {
        console.log('Absen DitLantas berhasil diinstall!');
        installButton.style.display = 'none';
    });

    // Khusus untuk iOS
    if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
        installButton.style.display = 'none';
        if (!isPWAInstalled()) {
            installInstructions.style.display = 'block';
        }
    }
</script>
@endpush
@endsection
