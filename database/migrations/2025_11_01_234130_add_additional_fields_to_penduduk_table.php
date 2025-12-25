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
            // Field tambahan dari mobile app
            $table->string('golongan_darah', 5)->nullable()->after('status_perkawinan');
            $table->string('kewarganegaraan', 50)->nullable()->default('Indonesia')->after('golongan_darah');
            $table->string('status_dalam_keluarga', 50)->nullable()->after('kewarganegaraan');
            $table->string('nama_ayah', 255)->nullable()->after('status_dalam_keluarga');
            $table->string('nama_ibu', 255)->nullable()->after('nama_ayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn([
                'golongan_darah',
                'kewarganegaraan',
                'status_dalam_keluarga',
                'nama_ayah',
                'nama_ibu',
            ]);
        });
    }
};
