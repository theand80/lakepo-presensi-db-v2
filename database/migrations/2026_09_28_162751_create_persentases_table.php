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
        Schema::create('persentases', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama');
            // 
            $table->string('01')->nullable();
            $table->string('02')->nullable();
            $table->string('03')->nullable();
            $table->string('04')->nullable();
            $table->string('05')->nullable();
            $table->string('06')->nullable();
            $table->string('07')->nullable();
            $table->string('08')->nullable();
            $table->string('09')->nullable();
            $table->string('10')->nullable();
            $table->string('11')->nullable();
            $table->string('12')->nullable();
            // 
            $table->string('next_01')->nullable();
            $table->string('next_02')->nullable();
            $table->string('next_03')->nullable();
            $table->string('next_04')->nullable();
            $table->string('next_05')->nullable();
            $table->string('next_06')->nullable();
            $table->string('next_07')->nullable();
            $table->string('next_08')->nullable();
            $table->string('next_09')->nullable();
            $table->string('next_10')->nullable();
            $table->string('next_11')->nullable();
            $table->string('next_12')->nullable();
            // 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persentases');
    }
};
