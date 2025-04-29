<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccuracyAndDeviceInfoToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Tambah kolom accuracy
            $table->float('check_in_accuracy')->nullable()->after('check_in_longitude');
            $table->float('check_out_accuracy')->nullable()->after('check_out_longitude');
            
            // Tambah kolom informasi perangkat
            $table->string('check_in_device')->nullable()->after('check_in_accuracy');
            $table->string('check_out_device')->nullable()->after('check_out_accuracy');
            
            // Tambah kolom status validasi
            $table->boolean('check_in_valid')->default(true)->after('check_in_device');
            $table->boolean('check_out_valid')->default(true)->after('check_out_device');
            
            // Tambah kolom catatan
            $table->text('check_in_notes')->nullable()->after('check_in_valid');
            $table->text('check_out_notes')->nullable()->after('check_out_valid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'check_in_accuracy',
                'check_out_accuracy',
                'check_in_device',
                'check_out_device',
                'check_in_valid',
                'check_out_valid',
                'check_in_notes',
                'check_out_notes'
            ]);
        });
    }
}
