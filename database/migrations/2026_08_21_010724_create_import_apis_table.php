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
        Schema::create('import_apis', function (Blueprint $table) {
            $table->id();
            $table->string('nip'); //""
            $table->string('nama'); //""
            $table->string('date'); //"2026-08-01 dari script"
            $table->string('libur'); //"1"
            $table->string('kegiatan'); //"1"

            $table->string('unor_simpegnas')->nullable(); //"BKPSDM"
            $table->string('unor_simpegnas_id')->nullable(); //"123-abc-234"

            $table->string('tahun')->nullable(); //"2026"
            $table->string('bulan')->nullable(); //"8"
            $table->string('day')->nullable(); //13
            // ---
            // $table->string('checkIn');
            $table->string('checkIn_work_from'); //"WFO"
            $table->string('checkIn_status'); //"HN"
            $table->string('checkIn_status_change')->nullable(); //"HN"
            $table->string('checkIn_time_with_timezone'); //"09:20:36"
            $table->string('checkIn_time_with_timezone_change')->nullable(); //"07:20:36"
            $table->string('checkIn_late'); //0
            // ---
            // $table->string('checkRest');
            $table->string('checkRest_work_from');
            $table->string('checkRest_status');
            $table->string('checkRest_status_change')->nullable();
            $table->string('checkRest_time_with_timezone');
            $table->string('checkRest_time_with_timezone_change')->nullable();
            $table->string('checkRest_late');
            // ---
            // $table->string('checkOut');
            $table->string('checkOut_work_from');
            $table->string('checkOut_status');
            $table->string('checkOut_status_change')->nullable();
            $table->string('checkOut_time_with_timezone');
            $table->string('checkOut_time_with_timezone_change')->nullable();
            $table->string('checkOut_late');
            // ---
            $table->string('status'); //"TK"
            $table->string('status_change')->nullable(); //"TK"
            $table->string('late'); //0
            $table->string('tak');
            $table->timestamps();
            // --- 
            $table->unique(['nip', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_apis');
    }
};
