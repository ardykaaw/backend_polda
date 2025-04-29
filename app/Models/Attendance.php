<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_in_photo',
        'check_in_latitude',
        'check_in_longitude',
        'check_out',
        'check_out_photo',
        'check_out_latitude',
        'check_out_longitude',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'check_in_latitude' => 'decimal:8',
        'check_in_longitude' => 'decimal:8',
        'check_in_accuracy' => 'float',
        'check_in_valid' => 'boolean',
        'check_out_latitude' => 'decimal:8',
        'check_out_longitude' => 'decimal:8',
        'check_out_accuracy' => 'float',
        'check_out_valid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCheckInDistanceAttribute()
    {
        return $this->calculateDistance(
            $this->check_in_latitude,
            $this->check_in_longitude,
            config('attendance.office_latitude'),
            config('attendance.office_longitude')
        );
    }

    public function getCheckOutDistanceAttribute()
    {
        return $this->calculateDistance(
            $this->check_out_latitude,
            $this->check_out_longitude,
            config('attendance.office_latitude'),
            config('attendance.office_longitude')
        );
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) {
            return null;
        }

        $earthRadius = 6371000; // radius bumi dalam meter

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)));

        return round($angle * $earthRadius); // jarak dalam meter
    }

    public function getAttendanceStatusAttribute()
    {
        if (!$this->check_in) {
            return 'Belum Absen';
        }

        $checkInTime = $this->check_in->format('H:i');
        $maxTime = config('attendance.max_check_in_time', '08:00');

        return $checkInTime <= $maxTime ? 'Tepat Waktu' : 'Terlambat';
    }

    public function getLocationValidAttribute()
    {
        $maxDistance = config('attendance.max_distance', 100); // dalam meter
        
        if ($this->check_in_distance > $maxDistance) {
            return false;
        }

        if ($this->check_out && $this->check_out_distance > $maxDistance) {
            return false;
        }

        return true;
    }
}
