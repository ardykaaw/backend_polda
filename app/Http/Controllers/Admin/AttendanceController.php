<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        // Data dummy untuk testing UI
        $attendances = [
            [
                'id' => 1,
                'nama' => 'John Doe',
                'nrp' => '123456',
                'pangkat' => 'BRIPDA',
                'divisi' => 'SATLANTAS',
                'tanggal' => '2024-04-19',
                'check_in' => '07:30',
                'check_out' => '16:30',
                'status' => 'Tepat Waktu',
                'lokasi' => 'Jl. Sudirman No. 1, Jakarta',
                'koordinat' => '-6.175392, 106.827153',
                'foto_masuk' => 'diki.jpg',
                'foto_keluar' => 'dilla.jpg',
                'detail' => [
                    'device' => 'iPhone 12',
                    'browser' => 'Safari Mobile',
                    'ip_address' => '192.168.1.1',
                    'lokasi_masuk' => 'Gedung Utama Lt. 1',
                    'lokasi_keluar' => 'Gedung Utama Lt. 1',
                    'catatan' => 'Kehadiran normal'
                ]
            ],
            [
                'id' => 2,
                'nama' => 'Jane Smith',
                'nrp' => '123457',
                'pangkat' => 'BRIPTU',
                'divisi' => 'SATLANTAS',
                'tanggal' => '2024-04-19',
                'check_in' => '08:15',
                'check_out' => '17:00',
                'status' => 'Terlambat',
                'lokasi' => 'Jl. Gatot Subroto No. 10, Jakarta',
                'koordinat' => '-6.178392, 106.827153',
                'foto_masuk' => 'sample3.jpg',
                'foto_keluar' => 'sample4.jpg'
            ],
            [
                'id' => 3,
                'nama' => 'Mike Johnson',
                'nrp' => '123458',
                'pangkat' => 'BRIPDA',
                'divisi' => 'SATLANTAS',
                'tanggal' => '2024-04-19',
                'check_in' => '07:15',
                'check_out' => '16:45',
                'status' => 'Tepat Waktu',
                'lokasi' => 'Jl. Thamrin No. 5, Jakarta',
                'koordinat' => '-6.176392, 106.827153',
                'foto_masuk' => 'sample5.jpg',
                'foto_keluar' => 'sample6.jpg'
            ],
            // Tambahkan 7 data dummy lagi dengan variasi waktu dan status
            [
                'id' => 4,
                'nama' => 'Sarah Wilson',
                'nrp' => '123459',
                'pangkat' => 'BRIPTU',
                'divisi' => 'SATLANTAS',
                'tanggal' => '2024-04-19',
                'check_in' => '07:45',
                'check_out' => '16:30',
                'status' => 'Tepat Waktu',
                'lokasi' => 'Jl. Rasuna Said No. 15, Jakarta',
                'koordinat' => '-6.174392, 106.827153',
                'foto_masuk' => 'sample7.jpg',
                'foto_keluar' => 'sample8.jpg'
            ],
            [
                'id' => 5,
                'nama' => 'David Brown',
                'nrp' => '123460',
                'pangkat' => 'BRIPDA',
                'divisi' => 'SATLANTAS',
                'tanggal' => '2024-04-19',
                'check_in' => '08:30',
                'check_out' => '17:15',
                'status' => 'Terlambat',
                'lokasi' => 'Jl. Kuningan No. 8, Jakarta',
                'koordinat' => '-6.173392, 106.827153',
                'foto_masuk' => 'sample9.jpg',
                'foto_keluar' => 'sample10.jpg'
            ],
            [
                'id' => 6,
                'nama' => 'Emily Davis',
                'nrp' => '123461',
                'pangkat' => 'BRIPTU',
                'divisi' => 'SATLANTAS',
                'tanggal' => '2024-04-19',
                'check_in' => '07:20',
                'check_out' => '16:15',
                'status' => 'Tepat Waktu',
                'lokasi' => 'Jl. Casablanca No. 12, Jakarta',
                'koordinat' => '-6.172392, 106.827153',
                'foto_masuk' => 'sample11.jpg',
                'foto_keluar' => 'sample12.jpg'
            ],
            [
                'id' => 7,
                'nama' => 'Michael Lee',
                'nrp' => '123462',
                'pangkat' => 'BRIPDA',
                'divisi' => 'SATLANTAS',
                'tanggal' => '2024-04-19',
                'check_in' => '08:45',
                'check_out' => '17:30',
                'status' => 'Terlambat',
                'lokasi' => 'Jl. Sudirman No. 25, Jakarta',
                'koordinat' => '-6.171392, 106.827153',
                'foto_masuk' => 'sample13.jpg',
                'foto_keluar' => 'sample14.jpg'
            ],
        ];

        return view('admin.attendance.index', compact('attendances'));
    }
}
