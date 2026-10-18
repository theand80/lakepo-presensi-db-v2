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
        Schema::dropIfExists('user_unor');

        Schema::create('user_unor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('unor_siasn_induk');
            $table->timestamps();
            $table->unique(['user_id', 'unor_siasn_induk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_unor');

        Schema::create('user_unor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('list_kantor_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'list_kantor_id']);
        });
    }
};
