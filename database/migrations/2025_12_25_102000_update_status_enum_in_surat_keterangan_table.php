<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'diproses' and 'selesai' (and keep 'disetujui' for backward compatibility if needed)
        DB::statement("ALTER TABLE surat_keterangan MODIFY COLUMN status ENUM('pending', 'diproses', 'disetujui', 'selesai', 'ditolak') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::statement("ALTER TABLE surat_keterangan MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak') NOT NULL DEFAULT 'pending'");
    }
};
