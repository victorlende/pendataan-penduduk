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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->comment('UUID untuk sinkronisasi mobile');
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan');
            $table->string('no_kk', 16)->comment('Nomor Kartu Keluarga');
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->string('rt_rw', 10)->comment('Format: 001/002');
            $table->text('alamat_lengkap');
            $table->string('no_telp', 20)->nullable();
            $table->string('photo_ktp')->nullable()->comment('Path foto KTP');

            // Relasi user
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()
                ->comment('User ID jika penduduk punya akun masyarakat');
            $table->foreignId('created_by')->constrained('users')->comment('User ID petugas yang input');

            // Sync tracking
            $table->boolean('is_synced')->default(false)->comment('Status sinkronisasi dari mobile');
            $table->timestamp('synced_at')->nullable()->comment('Waktu terakhir sync');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('nik');
            $table->index('no_kk');
            $table->index('rt_rw');
            $table->index('is_synced');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
