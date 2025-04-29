<?php

return [
    // Koordinat kantor
    'office_latitude' => env('OFFICE_LATITUDE', -6.175392),
    'office_longitude' => env('OFFICE_LONGITUDE', 106.827153),
    
    // Batas maksimum
    'max_distance' => env('MAX_ATTENDANCE_DISTANCE', 100), // dalam meter
    'max_accuracy' => env('MAX_GPS_ACCURACY', 50), // dalam meter
    'max_check_in_time' => env('MAX_CHECK_IN_TIME', '08:00'),
    
    // Pengaturan validasi
    'require_location' => env('REQUIRE_LOCATION', true),
    'require_device_info' => env('REQUIRE_DEVICE_INFO', true),
];
