<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel items — barang temuan yang dilaporkan.
 * Dipetakan dari halaman H-02 Cari Barang dan H-03 Detail Barang (Pertemuan 3).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // Data yang tampil pada postingan publik (AC-03.1)
            $table->string('name');
            $table->string('category');          // Dompet | Elektronik | Kunci | Lain-lain
            $table->string('location');
            $table->string('faculty');           // dasar pembatasan akses petugas (AC-08.3)
            $table->date('found_at');

            // Jalur penanganan, ditentukan dari kategori (AC-03.3 dan AC-03.4)
            $table->string('route')->default('posko');   // posko | penemu
            $table->string('finder_contact')->nullable(); // hanya diisi pada jalur penemu

            // Ciri tersembunyi — tidak pernah ditampilkan di antarmuka mahasiswa
            // (US-04, AC-04.1, AC-04.2). Hanya terbaca pada halaman petugas.
            $table->text('hidden_traits');

            // Siklus hidup barang
            $table->string('status')->default('aktif');
            // aktif | menunggu_pengambilan | sudah_diserahkan | arsip
            $table->date('expires_at')->nullable(); // masa tayang (AC-X.1, AC-X.2)

            $table->timestamps();

            $table->index(['category', 'status']);
            $table->index('faculty');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
