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
        Schema::create('list_kantors', function (Blueprint $table) {
            $table->id();
            $table->string('id_kantor');
            $table->string('nama_kantor');
            $table->string('bulan_1')->nullable();
            $table->string('bulan_2')->nullable();
            $table->string('bulan_3')->nullable();
            $table->string('bulan_4')->nullable();
            $table->string('bulan_5')->nullable();
            $table->string('bulan_6')->nullable();
            $table->string('bulan_7')->nullable();
            $table->string('bulan_8')->nullable();
            $table->string('bulan_9')->nullable();
            $table->string('bulan_10')->nullable();
            $table->string('bulan_11')->nullable();
            $table->string('bulan_12')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_kantors');
    }
};
