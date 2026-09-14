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
        Schema::create('data_asns', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama');
            $table->string('pangkat');
            $table->string('golongan');
            $table->string('status'); //pns p3k pw
            $table->string('jabatan');
            $table->string('unor_siasn');
            $table->string('unor_siasn_induk');
            $table->string('unor_simpegnas_id');
            $table->string('unor_simpegnas');
            $table->string('foto_simpegnas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_asns');
    }
};
