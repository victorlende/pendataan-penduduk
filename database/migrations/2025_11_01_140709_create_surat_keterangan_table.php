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
        Schema::create('surat_keterangan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 50)->unique()->comment('Format: SKD/001/X/2025');
            $table->foreignId('pemohon_id')->constrained('penduduk')->cascadeOnDelete()
                ->comment('ID penduduk yang mengajukan');
            $table->enum('jenis_surat', [
                'domisili',
                'tidak_mampu',
                'usaha',
                'kelahiran',
                'kematian'
            ]);
            $table->text('keperluan')->comment('Keperluan surat');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('file_surat')->nullable()->comment('Path file PDF surat');
            $table->text('catatan_admin')->nullable()->comment('Catatan dari admin');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()
                ->comment('Admin yang approve/reject');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('nomor_surat');
            $table->index('pemohon_id');
            $table->index('status');
            $table->index('jenis_surat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan');
    }
};
