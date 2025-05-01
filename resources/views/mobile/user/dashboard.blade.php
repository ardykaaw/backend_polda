@extends('mobile.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Photo Upload Section -->
    <div class="bg-white rounded-xl p-4 shadow">
        <h2 class="text-lg font-semibold mb-4">Foto Absensi</h2>
        <div class="grid grid-cols-2 gap-4">
            <!-- Check In Photo Card -->
            <div id="check-in-card" class="aspect-square">
                @if($attendance && $attendance->check_in_photo)
                    <div class="w-full h-full rounded-xl overflow-hidden relative">
                        <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" 
                             alt="Check In" 
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 p-2">
                            <p class="text-white text-sm text-center font-medium">
                                {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @else
                    <button onclick="handleCheckIn()" 
                            class="w-full h-full border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center hover:bg-gray-50 transition-colors">
                        <i class="fas fa-camera text-3xl text-gray-400 mb-2"></i>
                        <span class="text-sm text-gray-500">Foto Check In</span>
                    </button>
                @endif
            </div>

            <!-- Check Out Photo Card -->
            <div id="check-out-card" class="aspect-square">
                @if($attendance && $attendance->check_out_photo)
                    <div class="w-full h-full rounded-xl overflow-hidden relative">
                        <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" 
                             alt="Check Out" 
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 p-2">
                            <p class="text-white text-sm text-center font-medium">
                                {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @else
                    <button onclick="handleCheckOut()" 
                            class="w-full h-full border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center hover:bg-gray-50 transition-colors {{ (!$attendance || !$attendance->check_in_photo) ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ (!$attendance || !$attendance->check_in_photo) ? 'disabled' : '' }}>
                        <i class="fas fa-camera text-3xl text-gray-400 mb-2"></i>
                        <span class="text-sm text-gray-500">Foto Check Out</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div id="map-container" class="bg-white rounded-xl p-4 shadow">
        <h2 class="text-lg font-semibold mb-4">Lokasi Check In</h2>
        <div id="map" class="h-48 rounded-lg border border-gray-200"></div>
    </div>

    <!-- Action Buttons -->
    <div class="grid grid-cols-2 gap-4">
        <button onclick="handleCheckIn()" 
                class="bg-white p-4 rounded-xl shadow flex flex-col items-center justify-center {{ $attendance && $attendance->check_in_photo ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50' }}"
                {{ $attendance && $attendance->check_in_photo ? 'disabled' : '' }}>
            <i class="fas fa-sign-in-alt text-2xl text-blue-900 mb-2"></i>
            <span class="text-sm font-medium text-blue-900">Masuk</span>
            @if($attendance && $attendance->check_in)
                <span class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}</span>
            @endif
        </button>

        <button onclick="handleCheckOut()"
                class="bg-white p-4 rounded-xl shadow flex flex-col items-center justify-center {{ (!$attendance || !$attendance->check_in_photo) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50' }}"
                {{ (!$attendance || !$attendance->check_in_photo) ? 'disabled' : '' }}>
            <i class="fas fa-sign-out-alt text-2xl text-blue-900 mb-2"></i>
            <span class="text-sm font-medium text-blue-900">Keluar</span>
            @if($attendance && $attendance->check_out)
                <span class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}</span>
            @endif
        </button>
    </div>

    <!-- Recent Attendance -->
    <div class="bg-white rounded-xl p-4 shadow">
        <h2 class="text-lg font-semibold mb-4">Riwayat Terakhir</h2>
        <div id="attendance-history" class="space-y-4">
            @if($attendance && ($attendance->check_in || $attendance->check_out))
                <div class="border-b border-gray-100 pb-4">
                    <p class="text-sm text-gray-600">
                        {{ now()->format('d M Y') }}
                    </p>
                    <div class="mt-1 flex items-center">
                        <span class="text-sm font-medium">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '--:--' }}
                        </span>
                        <i class="fas fa-arrow-right text-xs mx-2 text-gray-400"></i>
                        <span class="text-sm font-medium">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '--:--' }}
                        </span>
                    </div>
                </div>
            @endif

            @forelse($recentAttendances as $record)
                <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                    <p class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                    </p>
                    <div class="mt-1 flex items-center">
                        <span class="text-sm font-medium">
                            {{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i') : '--:--' }}
                        </span>
                        <i class="fas fa-arrow-right text-xs mx-2 text-gray-400"></i>
                        <span class="text-sm font-medium">
                            {{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i') : '--:--' }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-4">
                    Belum ada riwayat absensi
                </p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
let map = null;
let marker = null;
let videoStream = null;
let currentCameraUI = null;

function initMap() {
    console.log('Initializing map...'); // Debug log

    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('Map element not found');
        return;
    }

    // Default center (bisa disesuaikan dengan lokasi Polda Sultra)
    const defaultLat = -3.9706;  // Latitude Kendari
    const defaultLng = 122.5150; // Longitude Kendari

    try {
        // Jika map belum diinisialisasi
        if (!map) {
            console.log('Creating new map instance');
            map = L.map('map');
            
            // Tambahkan tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
        }

        // Set view ke lokasi default atau lokasi check-in
        @if($attendance && $attendance->check_in_latitude && $attendance->check_in_longitude)
            const lat = {{ $attendance->check_in_latitude }};
            const lng = {{ $attendance->check_in_longitude }};
            console.log('Setting view to attendance location:', lat, lng);
            map.setView([lat, lng], 15);

            // Update atau tambah marker
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        @else
            console.log('Setting view to default location');
            map.setView([defaultLat, defaultLng], 13);
        @endif

        // Force map to update its container size
        setTimeout(() => {
            map.invalidateSize();
        }, 100);

    } catch (error) {
        console.error('Error initializing map:', error);
    }
}

// Inisialisasi map setelah DOM loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing map...');
    initMap();
});

// Pindahkan cleanup ke global scope
function cleanup() {
    console.log('Cleaning up camera resources');
    if (videoStream) {
        videoStream.getTracks().forEach(track => track.stop());
        videoStream = null;
    }
    if (currentCameraUI && document.body.contains(currentCameraUI)) {
        document.body.removeChild(currentCameraUI);
        currentCameraUI = null;
    }
}

async function handleCheckIn() {
    const checkInButton = document.querySelector('button[onclick="handleCheckIn()"]');
    if (checkInButton && checkInButton.disabled) {
        alert('Anda sudah melakukan check in hari ini');
        return;
    }
    
    try {
        const position = await getCurrentPosition();
        await openCamera('check-in', position);
    } catch (err) {
        alert('Error: ' + err.message);
    }
}

async function handleCheckOut() {
    const checkOutButton = document.querySelector('button[onclick="handleCheckOut()"]');
    const checkInButton = document.querySelector('button[onclick="handleCheckIn()"]');
    
    if (!checkInButton || !checkInButton.disabled) {
        alert('Anda harus check in terlebih dahulu');
        return;
    }
    
    if (checkOutButton && checkOutButton.disabled) {
        alert('Anda sudah melakukan check out hari ini');
        return;
    }
    
    try {
        const position = await getCurrentPosition();
        await openCamera('check-out', position);
    } catch (err) {
        alert('Error: ' + err.message);
    }
}

function getCurrentPosition() {
    return new Promise((resolve, reject) => {
        if (!navigator.geolocation) {
            reject(new Error('Geolocation tidak didukung oleh browser ini'));
            return;
        }

        navigator.geolocation.getCurrentPosition(
            position => {
                resolve({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                });
            },
            error => {
                reject(new Error('Tidak dapat mengakses lokasi. Pastikan GPS aktif dan izin lokasi diberikan.'));
            },
            { enableHighAccuracy: true }
        );
    });
}

async function openCamera(type, position) {
    // Cleanup any existing camera UI first
    cleanup();

    // Camera facing mode state
    let facingMode = 'environment';

    // Create camera UI
    const cameraUI = document.createElement('div');
    currentCameraUI = cameraUI; // Store reference to current UI
    cameraUI.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: black;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    `;

    // Create video element
    const video = document.createElement('video');
    video.style.cssText = `
        width: 100%;
        height: calc(100% - 100px);
        object-fit: cover;
    `;
    video.setAttribute('autoplay', '');
    video.setAttribute('playsinline', '');

    // Create canvas (hidden, for capturing photo)
    const canvas = document.createElement('canvas');
    canvas.style.display = 'none';

    // Create button container
    const buttonContainer = document.createElement('div');
    buttonContainer.style.cssText = `
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        background: black;
    `;

    // Create capture button
    const captureButton = document.createElement('button');
    captureButton.style.cssText = `
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: white;
        border: 3px solid #666;
    `;

    // Create switch camera button
    const switchButton = document.createElement('button');
    switchButton.style.cssText = `
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #eee;
        border: 2px solid #666;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #333;
    `;
    switchButton.title = 'Ganti Kamera';
    switchButton.innerHTML = '<i class="fas fa-sync-alt"></i>';

    // Create close button
    const closeButton = document.createElement('button');
    closeButton.style.cssText = `
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255,255,255,0.5);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: black;
        font-size: 20px;
    `;
    closeButton.innerHTML = '×';

    // Append elements
    buttonContainer.appendChild(switchButton);
    buttonContainer.appendChild(captureButton);
    cameraUI.appendChild(video);
    cameraUI.appendChild(buttonContainer);
    cameraUI.appendChild(closeButton);
    document.body.appendChild(cameraUI);

    // Camera stream logic
    async function startCamera() {
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
        }
        try {
            videoStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: facingMode },
                audio: false
            });
            video.srcObject = videoStream;
            // Mirror untuk kamera depan, normal untuk kamera belakang
            if (facingMode === 'user') {
                video.style.transform = 'scaleX(-1)';
            } else {
                video.style.transform = 'scaleX(1)';
            }
        } catch (error) {
            console.error('Camera error:', error);
            alert('Error: ' + error.message);
            cleanup();
        }
    }

    // Initial camera start
    await startCamera();

    // Handle switch camera button click
    switchButton.onclick = async () => {
        facingMode = (facingMode === 'environment') ? 'user' : 'environment';
        await startCamera();
    };

    // Handle capture button click
    captureButton.onclick = async () => {
        try {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            
            const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg'));
            
            const formData = new FormData();
            formData.append('photo', blob, 'photo.jpg');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('latitude', position.latitude);
            formData.append('longitude', position.longitude);

            captureButton.disabled = true;
            captureButton.style.opacity = '0.5';

            const endpoint = type === 'check-in' ? 
                '{{ route("mobile.attendance.check-in") }}' : 
                '{{ route("mobile.attendance.check-out") }}';

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            console.log('Server response:', result);

            if (!response.ok) {
                throw new Error(result.message || 'Gagal mengunggah foto');
            }

            // Update UI
            updateUI(type, result.data);
            cleanup();

        } catch (error) {
            console.error('Capture error:', error);
            alert('Error: ' + error.message);
            cleanup();
        }
    };

    // Handle close button click
    closeButton.onclick = cleanup;

    // Pada openCamera, simpan facingMode terakhir ke window.lastFacingMode
    window.lastFacingMode = facingMode;
}

function updateUI(type, data) {
    console.log('Updating UI with:', type, data);

    // Update photo card
    const photoCard = document.querySelector(type === 'check-in' ? '#check-in-card' : '#check-out-card');
    if (photoCard) {
        // Deteksi apakah foto dari kamera depan (user) atau belakang (environment)
        // Asumsi: jika type check-in/check-out, kita bisa simpan info facingMode di data.photo_facing_mode jika backend mengirimkannya
        // Namun, jika tidak ada, kita asumsikan check-in dan check-out bisa dari kamera depan atau belakang
        // Untuk konsistensi, kita mirror jika facingMode terakhir adalah 'user'
        let lastFacingMode = window.lastFacingMode || 'environment';
        let imgTransform = (lastFacingMode === 'user') ? 'scaleX(-1)' : 'scaleX(1)';
        photoCard.innerHTML = `
            <div class="w-full h-full rounded-xl overflow-hidden relative">
                <img src="/storage/${data.photo_url}" 
                     alt="${type === 'check-in' ? 'Check In' : 'Check Out'}" 
                     class="w-full h-full object-cover"
                     style="transform: ${imgTransform};"
                     onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 p-2">
                    <p class="text-white text-sm text-center font-medium">
                        ${type === 'check-in' ? data.check_in_time : data.check_out_time}
                    </p>
                </div>
            </div>
        `;
    }

    // Update map if check-in
    if (type === 'check-in' && data.latitude && data.longitude) {
        if (!map) {
            initMap();
        }
        const lat = parseFloat(data.latitude);
        const lng = parseFloat(data.longitude);
        map.setView([lat, lng], 15);
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
        map.invalidateSize();
    }

    // Update attendance history
    const historyContainer = document.querySelector('#attendance-history');
    if (historyContainer) {
        let existingToday = historyContainer.querySelector('.today-record');
        const today = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        
        if (existingToday) {
            // Update existing record
            const timeSpan = existingToday.querySelector(type === 'check-in' ? '.check-in-time' : '.check-out-time');
            if (timeSpan) {
                timeSpan.textContent = type === 'check-in' ? data.check_in_time : data.check_out_time;
            }
        } else {
            // Create new record for today
            const newRecord = document.createElement('div');
            newRecord.className = 'today-record border-b border-gray-100 pb-4';
            newRecord.innerHTML = `
                <p class="text-sm text-gray-600">${today}</p>
                <div class="mt-1 flex items-center">
                    <span class="text-sm font-medium check-in-time">
                        ${type === 'check-in' ? data.check_in_time : '--:--'}
                    </span>
                    <i class="fas fa-arrow-right text-xs mx-2 text-gray-400"></i>
                    <span class="text-sm font-medium check-out-time">
                        ${type === 'check-out' ? data.check_out_time : '--:--'}
                    </span>
                </div>
            `;
            historyContainer.insertBefore(newRecord, historyContainer.firstChild);
        }
    }

    // Update action buttons
    const checkInButton = document.querySelector('button[onclick="handleCheckIn()"]');
    const checkOutButton = document.querySelector('button[onclick="handleCheckOut()"]');

    if (type === 'check-in') {
        // Disable check-in button and enable check-out button
        if (checkInButton) {
            checkInButton.disabled = true;
            checkInButton.classList.add('opacity-50', 'cursor-not-allowed');
            if (checkInButton.querySelector('.text-xs')) {
                checkInButton.querySelector('.text-xs').textContent = data.check_in_time;
            }
        }
        if (checkOutButton) {
            checkOutButton.disabled = false;
            checkOutButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    } else if (type === 'check-out') {
        // Disable check-out button
        if (checkOutButton) {
            checkOutButton.disabled = true;
            checkOutButton.classList.add('opacity-50', 'cursor-not-allowed');
            if (checkOutButton.querySelector('.text-xs')) {
                checkOutButton.querySelector('.text-xs').textContent = data.check_out_time;
            }
        }
    }

    // Update the empty state message if exists
    const emptyState = document.querySelector('.text-center.text-gray-500.py-4');
    if (emptyState && emptyState.textContent.trim() === 'Belum ada riwayat absensi') {
        emptyState.remove();
    }
}

// Add event listener for page unload to ensure cleanup
window.addEventListener('beforeunload', cleanup);

// Add event listener for visibility change
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        cleanup();
    }
});
</script>

<style>
.camera-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: black;
    z-index: 9999;
    display: flex;
    flex-direction: column;
}

#camera {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        width: 100%;
        height: 300px;
        border-radius: 0.5rem;
    }
    .leaflet-container {
        z-index: 1;
    }
</style>
@endpush
@endsection
