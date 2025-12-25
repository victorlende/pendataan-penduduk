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
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('Petugas yang melakukan sync');
            $table->string('device_id')->nullable()->comment('Device identifier dari mobile');
            $table->enum('action', ['create', 'update', 'delete'])->comment('Jenis aksi sync');
            $table->string('table_name', 50)->comment('Nama tabel yang di-sync');
            $table->integer('record_count')->default(0)->comment('Jumlah record yang di-sync');
            $table->integer('success_count')->default(0)->comment('Jumlah record berhasil');
            $table->integer('failed_count')->default(0)->comment('Jumlah record gagal');
            $table->json('errors')->nullable()->comment('Detail error jika ada');
            $table->timestamp('created_at')->useCurrent();

            // Indexes
            $table->index('user_id');
            $table->index('device_id');
            $table->index('table_name');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_logs');
    }
};
