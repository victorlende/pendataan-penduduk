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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas', 'masyarakat'])->default('masyarakat')
                ->after('email')->comment('Role pengguna');
            $table->string('rt_rw', 10)->nullable()->after('role')
                ->comment('RT/RW untuk petugas (Format: 001/002)');
            $table->string('telegram_chat_id')->nullable()->after('rt_rw')
                ->comment('Telegram Chat ID untuk notifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'rt_rw', 'telegram_chat_id']);
        });
    }
};
