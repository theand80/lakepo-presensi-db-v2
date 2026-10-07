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
        Schema::table('data_absens', function (Blueprint $table) {
            // dipakai oleh hitung persentase: where unor_simpegnas_id + date like 'Y-m%'
            $table->index(['unor_simpegnas_id', 'date'], 'data_absens_unor_date_index');

            // dipakai oleh halaman listing persentase: whereIn date (12 tanggal tanggal-01)
            $table->index('date', 'data_absens_date_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_absens', function (Blueprint $table) {
            $table->dropIndex('data_absens_unor_date_index');
            $table->dropIndex('data_absens_date_index');
        });
    }
};
