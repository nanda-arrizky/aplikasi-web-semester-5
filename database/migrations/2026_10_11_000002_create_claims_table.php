<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel claims — pengajuan klaim atas barang temuan.
 * Dipetakan dari halaman H-04 Form Klaim dan H-05 Klaim Saya (Pertemuan 3).
 * Relasi: satu Item dapat memiliki banyak Claim.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();

            // Autentikasi belum masuk lingkup, identitas pengklaim diisi manual
            $table->string('claimant_name');

            // Deskripsi kepemilikan — dibandingkan petugas dengan hidden_traits (AC-08.2)
            $table->text('ownership_description');

            $table->string('status')->default('menunggu');
            // menunggu | disetujui | ditolak | ditolak_otomatis

            // Jejak keputusan (AC-09.3, AC-09.4)
            $table->text('decision_reason')->nullable();
            $table->string('decided_by')->nullable();
            $table->timestamp('decided_at')->nullable();

            $table->timestamps();

            $table->index(['item_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
