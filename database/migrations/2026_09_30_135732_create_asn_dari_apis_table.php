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
        Schema::create('asn_dari_apis', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('pangkat')->nullable();
            $table->string('golongan')->nullable();
            $table->string('status')->nullable(); //pns p3k pw
            $table->string('jabatan')->nullable();
            $table->string('unor_siasn')->nullable();
            $table->string('unor_siasn_induk')->nullable();
            $table->string('unor_simpegnas_id');
            $table->string('unor_simpegnas');
            $table->string('foto_simpegnas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asn_dari_apis');
    }
};
