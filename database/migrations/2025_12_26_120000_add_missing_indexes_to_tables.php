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
        // Add indexes to kks table
        if (!$this->indexExists('kks', 'idx_kks_dusun_id')) {
            DB::statement('ALTER TABLE `kks` ADD INDEX `idx_kks_dusun_id` (`dusun_id`)');
        }
        if (!$this->indexExists('kks', 'idx_kks_created_by')) {
            DB::statement('ALTER TABLE `kks` ADD INDEX `idx_kks_created_by` (`created_by`)');
        }
        if (!$this->indexExists('kks', 'idx_kks_rt')) {
            DB::statement('ALTER TABLE `kks` ADD INDEX `idx_kks_rt` (`rt`)');
        }
        if (!$this->indexExists('kks', 'idx_kks_rw')) {
            DB::statement('ALTER TABLE `kks` ADD INDEX `idx_kks_rw` (`rw`)');
        }

        // Add indexes to mutasi table
        if (!$this->indexExists('mutasi', 'idx_mutasi_penduduk_id')) {
            DB::statement('ALTER TABLE `mutasi` ADD INDEX `idx_mutasi_penduduk_id` (`penduduk_id`)');
        }
        if (!$this->indexExists('mutasi', 'idx_mutasi_jenis_mutasi')) {
            DB::statement('ALTER TABLE `mutasi` ADD INDEX `idx_mutasi_jenis_mutasi` (`jenis_mutasi`)');
        }
        if (!$this->indexExists('mutasi', 'idx_mutasi_tanggal_mutasi')) {
            DB::statement('ALTER TABLE `mutasi` ADD INDEX `idx_mutasi_tanggal_mutasi` (`tanggal_mutasi`)');
        }

        // Add additional indexes to penduduk table
        if (!$this->indexExists('penduduk', 'idx_penduduk_kk_id')) {
            DB::statement('ALTER TABLE `penduduk` ADD INDEX `idx_penduduk_kk_id` (`kk_id`)');
        }
        if (!$this->indexExists('penduduk', 'idx_penduduk_user_id')) {
            DB::statement('ALTER TABLE `penduduk` ADD INDEX `idx_penduduk_user_id` (`user_id`)');
        }
        if (!$this->indexExists('penduduk', 'idx_penduduk_nama_lengkap')) {
            DB::statement('ALTER TABLE `penduduk` ADD INDEX `idx_penduduk_nama_lengkap` (`nama_lengkap`)');
        }
        if (!$this->indexExists('penduduk', 'idx_penduduk_jenis_kelamin')) {
            DB::statement('ALTER TABLE `penduduk` ADD INDEX `idx_penduduk_jenis_kelamin` (`jenis_kelamin`)');
        }
        if (!$this->indexExists('penduduk', 'idx_penduduk_status_penduduk')) {
            DB::statement('ALTER TABLE `penduduk` ADD INDEX `idx_penduduk_status_penduduk` (`status_penduduk`)');
        }

        // Add indexes to users table
        if (!$this->indexExists('users', 'idx_users_role')) {
            DB::statement('ALTER TABLE `users` ADD INDEX `idx_users_role` (`role`)');
        }
        if (!$this->indexExists('users', 'idx_users_status')) {
            DB::statement('ALTER TABLE `users` ADD INDEX `idx_users_status` (`status`)');
        }
        if (!$this->indexExists('users', 'idx_users_rt_rw')) {
            DB::statement('ALTER TABLE `users` ADD INDEX `idx_users_rt_rw` (`rt_rw`)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from kks table
        if ($this->indexExists('kks', 'idx_kks_dusun_id')) {
            DB::statement('ALTER TABLE `kks` DROP INDEX `idx_kks_dusun_id`');
        }
        if ($this->indexExists('kks', 'idx_kks_created_by')) {
            DB::statement('ALTER TABLE `kks` DROP INDEX `idx_kks_created_by`');
        }
        if ($this->indexExists('kks', 'idx_kks_rt')) {
            DB::statement('ALTER TABLE `kks` DROP INDEX `idx_kks_rt`');
        }
        if ($this->indexExists('kks', 'idx_kks_rw')) {
            DB::statement('ALTER TABLE `kks` DROP INDEX `idx_kks_rw`');
        }

        // Drop indexes from mutasi table
        if ($this->indexExists('mutasi', 'idx_mutasi_penduduk_id')) {
            DB::statement('ALTER TABLE `mutasi` DROP INDEX `idx_mutasi_penduduk_id`');
        }
        if ($this->indexExists('mutasi', 'idx_mutasi_jenis_mutasi')) {
            DB::statement('ALTER TABLE `mutasi` DROP INDEX `idx_mutasi_jenis_mutasi`');
        }
        if ($this->indexExists('mutasi', 'idx_mutasi_tanggal_mutasi')) {
            DB::statement('ALTER TABLE `mutasi` DROP INDEX `idx_mutasi_tanggal_mutasi`');
        }

        // Drop additional indexes from penduduk table
        if ($this->indexExists('penduduk', 'idx_penduduk_kk_id')) {
            DB::statement('ALTER TABLE `penduduk` DROP INDEX `idx_penduduk_kk_id`');
        }
        if ($this->indexExists('penduduk', 'idx_penduduk_user_id')) {
            DB::statement('ALTER TABLE `penduduk` DROP INDEX `idx_penduduk_user_id`');
        }
        if ($this->indexExists('penduduk', 'idx_penduduk_nama_lengkap')) {
            DB::statement('ALTER TABLE `penduduk` DROP INDEX `idx_penduduk_nama_lengkap`');
        }
        if ($this->indexExists('penduduk', 'idx_penduduk_jenis_kelamin')) {
            DB::statement('ALTER TABLE `penduduk` DROP INDEX `idx_penduduk_jenis_kelamin`');
        }
        if ($this->indexExists('penduduk', 'idx_penduduk_status_penduduk')) {
            DB::statement('ALTER TABLE `penduduk` DROP INDEX `idx_penduduk_status_penduduk`');
        }

        // Drop indexes from users table
        if ($this->indexExists('users', 'idx_users_role')) {
            DB::statement('ALTER TABLE `users` DROP INDEX `idx_users_role`');
        }
        if ($this->indexExists('users', 'idx_users_status')) {
            DB::statement('ALTER TABLE `users` DROP INDEX `idx_users_status`');
        }
        if ($this->indexExists('users', 'idx_users_rt_rw')) {
            DB::statement('ALTER TABLE `users` DROP INDEX `idx_users_rt_rw`');
        }
    }

    /**
     * Check if index exists on table using raw SQL query
     */
    private function indexExists(string $table, string $index): bool
    {
        $database = DB::getDatabaseName();

        $result = DB::select(
            "SELECT COUNT(*) as count
             FROM information_schema.statistics
             WHERE table_schema = ?
             AND table_name = ?
             AND index_name = ?",
            [$database, $table, $index]
        );

        return $result[0]->count > 0;
    }
};
