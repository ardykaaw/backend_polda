@extends('mobile.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
   

    <!-- Schedule List -->
    <div class="p-4 space-y-4">
        @forelse($schedules as $schedule)
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-blue-900">{{ $schedule->day }}</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-sm">
                        {{ $schedule->time_start }} - {{ $schedule->time_end }}
                    </span>
                </div>

                <div class="space-y-3">
                    <!-- Location -->
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-blue-900 mt-1"></i>
                        <p class="ml-3 text-gray-700">{{ $schedule->location }}</p>
                    </div>

                    <!-- Team Members -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Anggota Tim:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($schedule->members as $member)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                           bg-gray-100 text-gray-700">
                                    {{ $member->pangkat }} {{ $member->nama }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500">Belum ada jadwal tersedia</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
