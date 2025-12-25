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
        Schema::table('penduduk', function (Blueprint $table) {
            $table->foreignId('kk_id')->nullable()->after('id')->constrained('kks')->nullOnDelete();
            $table->enum('status_penduduk', ['Tetap', 'Pendatang', 'Pindah', 'Meninggal'])->default('Tetap')->after('status_perkawinan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropForeign(['kk_id']);
            $table->dropColumn(['kk_id', 'status_penduduk']);
        });
    }
};
