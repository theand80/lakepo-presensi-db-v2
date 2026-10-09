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
        Schema::create('penanda_tangans', function (Blueprint $table) {
            $table->id();
            // $table->string('unor_siasn')->nullable();
            $table->string('unor_siasn_induk');
            // $table->string('unor_simpegnas_id');
            // $table->string('unor_simpegnas');

            $table->string('sebagai');
            $table->string('nama_pen_ttd');
            $table->string('pangkat_gol');
            $table->string('nip');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penanda_tangans');
    }
};
