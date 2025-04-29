<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        try {
            Log::info('Check-in attempt', ['user_id' => auth()->id(), 'data' => $request->all()]);

            $request->validate([
                'photo' => 'required|image|max:5120',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            // Simpan foto
            $photo = $request->file('photo');
            $path = $photo->store('attendance-photos', 'public');

            // Cek apakah sudah ada attendance hari ini
            $attendance = Attendance::where('user_id', auth()->id())
                ->whereDate('date', Carbon::today())
                ->first();

            if ($attendance) {
                if ($attendance->check_in_photo) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda sudah melakukan check in hari ini'
                    ], 400);
                }
                
                $attendance->update([
                    'check_in' => Carbon::now(),
                    'check_in_photo' => $path,
                    'check_in_latitude' => (float) $request->latitude,
                    'check_in_longitude' => (float) $request->longitude,
                ]);
            } else {
                $attendance = Attendance::create([
                    'user_id' => auth()->id(),
                    'date' => Carbon::today(),
                    'check_in' => Carbon::now(),
                    'check_in_photo' => $path,
                    'check_in_latitude' => (float) $request->latitude,
                    'check_in_longitude' => (float) $request->longitude,
                ]);
            }

            Log::info('Check-in successful', ['attendance_id' => $attendance->id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Check in berhasil',
                'data' => [
                    'photo_url' => $path,
                    'check_in_time' => Carbon::parse($attendance->check_in)->format('H:i'),
                    'latitude' => (float) $attendance->check_in_latitude,
                    'longitude' => (float) $attendance->check_in_longitude
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Check-in failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan check in: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkOut(Request $request)
    {
        try {
            Log::info('Check-out attempt', ['user_id' => auth()->id(), 'data' => $request->all()]);

            $request->validate([
                'photo' => 'required|image|max:5120',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $attendance = Attendance::where('user_id', auth()->id())
                ->whereDate('date', Carbon::today())
                ->first();

            if (!$attendance || !$attendance->check_in_photo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda harus check in terlebih dahulu'
                ], 400);
            }

            if ($attendance->check_out_photo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda sudah melakukan check out hari ini'
                ], 400);
            }

            $photo = $request->file('photo');
            $path = $photo->store('attendance-photos', 'public');

            $attendance->update([
                'check_out' => Carbon::now(),
                'check_out_photo' => $path,
                'check_out_latitude' => $request->latitude,
                'check_out_longitude' => $request->longitude,
            ]);

            Log::info('Check-out successful', ['attendance_id' => $attendance->id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Check out berhasil',
                'data' => [
                    'photo_url' => $path,
                    'check_out_time' => Carbon::parse($attendance->check_out)->format('H:i'),
                    'latitude' => $attendance->check_out_latitude,
                    'longitude' => $attendance->check_out_longitude
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Check-out failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan check out: ' . $e->getMessage()
            ], 500);
        }
    }

    private function savePhoto($base64Image)
    {
        $image = str_replace('data:image/jpeg;base64,', '', $base64Image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'attendance_' . time() . '_' . uniqid() . '.jpg';
        
        Storage::disk('public')->put('attendance-photos/' . $imageName, base64_decode($image));
        
        return 'attendance-photos/' . $imageName;
    }

    private function determineStatus($checkInTime)
    {
        $startTime = Carbon::createFromTimeString('08:00:00');
        return $checkInTime->lt($startTime) ? 'tepat_waktu' : 'terlambat';
    }
}
