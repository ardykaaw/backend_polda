@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->nama }}</h1>
                    <p class="mt-1 text-gray-600">Monitoring Dashboard Ditlantas Polda</p>
                </div>
                <div class="hidden sm:block">
                    <span class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Users Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-50">
                        <i class="fas fa-users text-xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Attendance Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-50">
                        <i class="fas fa-clock text-xl text-indigo-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Kehadiran Hari Ini</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $todayAttendance }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- On Time Percentage Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-50">
                        <i class="fas fa-chart-pie text-xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Ketepatan Waktu</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $onTimePercentage }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Attendance Chart -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800">Statistik Kehadiran Mingguan</h3>
                <div class="mt-4" style="height: 300px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Division Distribution -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800">Distribusi Divisi</h3>
                <div class="mt-4" style="height: 300px;">
                    <canvas id="divisionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Attendance Chart
const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
new Chart(attendanceCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($weeklyLabels) !!},
        datasets: [{
            label: 'Tepat Waktu',
            data: {!! json_encode($weeklyOnTime) !!},
            borderColor: '#4F46E5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            tension: 0.3,
            fill: true
        }, {
            label: 'Terlambat',
            data: {!! json_encode($weeklyLate) !!},
            borderColor: '#EF4444',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Division Chart
const divisionCtx = document.getElementById('divisionChart').getContext('2d');
new Chart(divisionCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($divisionLabels) !!},
        datasets: [{
            data: {!! json_encode($divisionCounts) !!},
            backgroundColor: [
                '#4F46E5',
                '#10B981',
                '#F59E0B',
                '#EF4444',
                '#6366F1'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
@endsection
