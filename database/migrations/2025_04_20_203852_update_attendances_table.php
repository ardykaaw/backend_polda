<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->datetime('check_in')->nullable()->change();
            $table->datetime('check_out')->nullable()->change();
            
            $table->string('check_in_photo')->nullable()->after('check_in');
            $table->string('check_out_photo')->nullable()->after('check_out');
            
            $table->dropColumn(['check_in_location', 'check_out_location']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('check_in')->nullable()->change();
            $table->time('check_out')->nullable()->change();
            
            $table->dropColumn(['check_in_photo', 'check_out_photo']);
            
            $table->string('check_in_location')->nullable();
            $table->string('check_out_location')->nullable();
        });
    }
};
