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
        // Add 'warga' to the enum list using raw SQL as Laravel Schema builder doesn't support changing ENUM values easily on all drivers
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'masyarakat', 'warga') NOT NULL DEFAULT 'masyarakat'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original (WARNING: 'warga' roles might be compromised if reverted)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'masyarakat') NOT NULL DEFAULT 'masyarakat'");
    }
};
