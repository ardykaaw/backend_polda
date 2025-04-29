@extends('admin.layouts.app')

@section('title', 'Monitoring Kehadiran')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <!-- Header dan Filter -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Monitoring Kehadiran</h2>
                <p class="mt-1 text-sm text-gray-600">Pantau kehadiran personel secara real-time</p>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                <!-- Input Tanggal -->
                <div class="relative">
                    <input type="date" 
                           class="form-input rounded-lg border-gray-300 focus:border-blue-500 w-full sm:w-auto"
                           value="{{ date('Y-m-d') }}"
                           style="-webkit-appearance: none;">
                </div>

                <!-- Select Status -->
                <div class="relative">
                    <select class="form-select rounded-lg border-gray-300 focus:border-blue-500 w-full sm:w-auto appearance-none">
                        <option value="">Semua Status</option>
                        <option value="tepat_waktu">Tepat Waktu</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Tombol Cari -->
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-150 w-full sm:w-auto flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Table Container with Shadow -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Personel
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Waktu Absen
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Status & Lokasi
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Dokumentasi
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($attendances as $attendance)
                <tr class="hover:bg-gray-50 transition-all duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">{{ substr($attendance['nama'], 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $attendance['nama'] }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                        NRP: {{ $attendance['nrp'] }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $attendance['pangkat'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <span class="w-20 text-gray-500">Masuk</span>
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-green-400 mr-2"></div>
                                    <span class="text-gray-900">{{ $attendance['check_in'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="w-20 text-gray-500">Keluar</span>
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-red-400 mr-2"></div>
                                    <span class="text-gray-900">{{ $attendance['check_out'] }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="space-y-2">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $attendance['status'] === 'Tepat Waktu' 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-red-100 text-red-800' }}">
                                {{ $attendance['status'] }}
                            </span>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                <span class="truncate max-w-xs">{{ $attendance['lokasi'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button" 
                                onclick="showAttendancePhotos()" 
                                class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg text-sm transition-colors duration-200">
                            <i class="fas fa-images mr-2"></i>
                            Lihat Foto
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button onclick="showAttendanceDetail('{{ $attendance['id'] }}')"
                                class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-sm transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination yang Diperbaiki -->
    <div class="bg-white px-6 py-4 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row items-center justify-between">
            <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                <span class="text-sm text-gray-700">
                    Menampilkan
                    <span class="font-semibold">1</span>
                    sampai
                    <span class="font-semibold">10</span>
                    dari
                    <span class="font-semibold">50</span>
                    data
                </span>
                <select class="form-select rounded-lg border-gray-300 text-sm focus:border-blue-500">
                    <option value="10">10 per halaman</option>
                    <option value="25">25 per halaman</option>
                    <option value="50">50 per halaman</option>
                </select>
            </div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <a href="#" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-chevron-left text-xs"></i>
                </a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">2</a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">8</a>
                <a href="#" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-chevron-right text-xs"></i>
                </a>
            </nav>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan foto -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Dokumentasi Kehadiran - John Doe</h3>
                <button onclick="closeAttendancePhotos()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Foto Check In (07:30)</h4>
                    <img src="{{ asset('images/diki.jpg') }}" 
                         alt="Check In" 
                         class="w-full h-64 object-cover rounded-lg">
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Foto Check Out (16:30)</h4>
                    <img src="{{ asset('images/dilla.JPG') }}" 
                         alt="Check Out" 
                         class="w-full h-64 object-cover rounded-lg">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg max-w-2xl w-full mx-4">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Detail Kehadiran</h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">Informasi Personel</h4>
                        <p class="mt-1 text-sm text-gray-600" id="detailNama"></p>
                        <p class="text-sm text-gray-600" id="detailNRP"></p>
                        <p class="text-sm text-gray-600" id="detailPangkat"></p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">Waktu Kehadiran</h4>
                        <p class="mt-1 text-sm text-gray-600" id="detailCheckIn"></p>
                        <p class="text-sm text-gray-600" id="detailCheckOut"></p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">Informasi Lokasi</h4>
                        <p class="mt-1 text-sm text-gray-600" id="detailLokasi"></p>
                        <p class="text-sm text-gray-600" id="detailKoordinat"></p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">Informasi Perangkat</h4>
                        <p class="mt-1 text-sm text-gray-600" id="detailDevice"></p>
                        <p class="text-sm text-gray-600" id="detailBrowser"></p>
                        <p class="text-sm text-gray-600" id="detailIP"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showAttendancePhotos() {
    const modal = document.getElementById('photoModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeAttendancePhotos() {
    const modal = document.getElementById('photoModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

function showAttendanceDetail(attendance) {
    console.log('Showing details for:', attendance); // Untuk debugging
    
    const modal = document.getElementById('detailModal');
    
    // Update semua informasi detail
    document.getElementById('detailNama').textContent = `Nama: ${attendance.nama}`;
    document.getElementById('detailNRP').textContent = `NRP: ${attendance.nrp}`;
    document.getElementById('detailPangkat').textContent = `Pangkat: ${attendance.pangkat} - ${attendance.divisi}`;
    document.getElementById('detailCheckIn').textContent = `Check In: ${attendance.check_in}`;
    document.getElementById('detailCheckOut').textContent = `Check Out: ${attendance.check_out}`;
    document.getElementById('detailLokasi').textContent = `Lokasi: ${attendance.lokasi}`;
    document.getElementById('detailKoordinat').textContent = `Koordinat: ${attendance.koordinat}`;
    
    if (attendance.detail) {
        document.getElementById('detailDevice').textContent = `Perangkat: ${attendance.detail.device}`;
        document.getElementById('detailBrowser').textContent = `Browser: ${attendance.detail.browser}`;
        document.getElementById('detailIP').textContent = `IP Address: ${attendance.detail.ip_address}`;
    }
    
    // Tampilkan modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Event listener untuk menutup modal saat klik di luar
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('photoModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAttendancePhotos();
            }
        });
    }
});

// Error handling untuk gambar
document.querySelectorAll('#checkInPhoto, #checkOutPhoto').forEach(img => {
    img.onerror = function() {
        this.src = `${BASE_URL}/images/placeholder.jpg`;
        console.error('Error loading image:', this.src);
    };
});
</script>
@endpush
