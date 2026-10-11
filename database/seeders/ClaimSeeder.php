<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Data klaim awal agar seluruh state pada H-05 dan H-06 dapat diperiksa
 * tanpa harus mengisi formulir satu per satu.
 */
class ClaimSeeder extends Seeder
{
    public function run(): void
    {
        $kunci     = Item::where('name', 'Kunci motor Honda')->first();
        $dompet    = Item::where('name', 'Dompet cokelat')->first();
        $powerbank = Item::where('name', 'Powerbank hitam')->first();

        if ($kunci) {
            // Menunggu verifikasi, baru beberapa jam
            Claim::create([
                'item_id'               => $kunci->id,
                'claimant_name'         => 'Dinda Pramesti',
                'ownership_description' => 'Gantungannya karet bergambar kucing warna oranye, '
                    . 'dan ada satu kunci kecil tambahan di ring yang sama.',
                'status'                => 'menunggu',
                'created_at'            => Carbon::now()->subHours(3),
                'updated_at'            => Carbon::now()->subHours(3),
            ]);
        }

        if ($dompet) {
            // Menunggu lebih dari 24 jam, akan bertanda Perlu ditinjau
            Claim::create([
                'item_id'               => $dompet->id,
                'claimant_name'         => 'Rangga Saputra',
                'ownership_description' => 'Dompet kulit cokelat, di dalamnya ada kartu perpustakaan '
                    . 'atas nama saya dan struk parkir. Bagian sudut bawahnya agak terkelupas.',
                'status'                => 'menunggu',
                'created_at'            => Carbon::now()->subHours(30),
                'updated_at'            => Carbon::now()->subHours(30),
            ]);
        }

        if ($powerbank) {
            // Sudah diputuskan: ditolak beserta alasan (AC-09.4)
            Claim::create([
                'item_id'               => $powerbank->id,
                'claimant_name'         => 'Ayu Lestari',
                'ownership_description' => 'Powerbank warna hitam merek Xiaomi, tidak ada stiker apa pun.',
                'status'                => 'ditolak',
                'decision_reason'       => 'Ciri yang disebutkan tidak sesuai dengan barang yang dititipkan.',
                'decided_by'            => 'Arif Setiawan',
                'decided_at'            => Carbon::now()->subDay(),
                'created_at'            => Carbon::now()->subDays(3),
                'updated_at'            => Carbon::now()->subDay(),
            ]);
        }
    }
}
