<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        \Log::info('=== Start Check-in Process ===');
        \Log::info('Request Data:', $request->all());
        
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'location' => 'required|string',
                'accuracy' => 'required|numeric|max:50', // akurasi dalam meter
            ]);

            // Validasi jarak
            if (!$this->validateDistance($request->latitude, $request->longitude)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda berada di luar area yang diizinkan untuk absen'
                ], 400);
            }

            // Validasi akurasi GPS
            if ($request->accuracy > 50) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sinyal GPS kurang akurat. Mohon coba lagi di area terbuka'
                ], 400);
            }

            // Log untuk mengecek existing attendance
            $existingAttendance = Attendance::where('user_id', $request->user_id)
                ->whereDate('date', Carbon::today())
                ->first();
            
            \Log::info('Existing Attendance:', [
                'exists' => $existingAttendance ? 'yes' : 'no',
                'data' => $existingAttendance
            ]);

            if ($existingAttendance) {
                \Log::info('User already checked in today');
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absen masuk hari ini'
                ], 400);
            }

            // Buat attendance baru
            $attendance = new Attendance();
            $attendance->user_id = $request->user_id;
            $attendance->date = Carbon::today();
            $attendance->check_in = Carbon::now()->format('H:i:s');
            $attendance->check_in_location = $request->location;
            $attendance->check_in_latitude = $request->latitude;
            $attendance->check_in_longitude = $request->longitude;
            $attendance->status = Carbon::now()->format('H:i') <= '08:00' ? 'tepat_waktu' : 'terlambat';
            
            \Log::info('New Attendance Data:', $attendance->toArray());
            
            $attendance->save();
            
            \Log::info('Check-in successful');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil melakukan absen masuk',
                'data' => $attendance
            ]);

        } catch (\Exception $e) {
            \Log::error('Check-in failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan absen masuk: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkOut(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'location' => 'required|string',
            ]);

            $attendance = Attendance::where('user_id', $request->user_id)
                ->whereDate('date', Carbon::today())
                ->whereNull('check_out')
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan absen masuk hari ini atau sudah melakukan absen keluar'
                ], 400);
            }

            $attendance->check_out = Carbon::now()->format('H:i:s');
            $attendance->check_out_location = $request->location;
            $attendance->check_out_latitude = $request->latitude;
            $attendance->check_out_longitude = $request->longitude;
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil melakukan absen keluar',
                'data' => $attendance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan absen keluar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history($userId)
    {
        \Log::info('=== FETCHING ATTENDANCE HISTORY ===');
        \Log::info('Requesting history for user_id: ' . $userId);
        
        try {
            $attendances = Attendance::where('user_id', $userId)
                ->orderBy('date', 'desc')
                ->get();

            \Log::info('Found attendances:', [
                'count' => $attendances->count(),
                'data' => $attendances
            ]);

            return response()->json([
                'success' => true,
                'data' => $attendances
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching history:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateDistance($latitude, $longitude, $officeLatitude = -6.175392, $officeLongitude = 106.827153, $maxDistance = 100)
    {
        // Rumus Haversine untuk menghitung jarak
        $earthRadius = 6371000; // Radius bumi dalam meter
        
        $latFrom = deg2rad($officeLatitude);
        $lonFrom = deg2rad($officeLongitude);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        
        $distance = $angle * $earthRadius;

        return $distance <= $maxDistance;
    }
}
