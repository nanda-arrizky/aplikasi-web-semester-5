<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Dompet cokelat', 'Dompet', 'Gedung LPTK lantai 2', 'Fakultas Teknik', 5,
             'Jahitan merah di lipatan dalam. Berisi kartu perpustakaan dan struk parkir. Sudut kanan bawah terkelupas.', null],

            ['Kunci motor Honda', 'Kunci', 'Kantin Fakultas Teknik', 'Fakultas Teknik', 6,
             'Gantungan karet bergambar kucing oranye. Satu kunci cadangan kecil menempel di ring yang sama.', null],

            ['Powerbank hitam', 'Elektronik', 'Perpustakaan UNY', 'Fakultas Teknik', 7,
             'Merek Anker 10000 mAh. Stiker logo UKM robotika di sisi belakang. Port USB-C agak longgar.', null],

            ['Kacamata bulat', 'Lain-lain', 'Ruang D07.206', 'Fakultas Teknik', 3,
             'Bingkai logam tipis warna emas. Gagang kiri dibalut selotip bening.', '0812-3456-7890'],

            ['Botol minum biru', 'Lain-lain', 'Lapangan FT', 'Fakultas Teknik', 2,
             'Tutup berwarna putih dengan bekas tulisan nama yang sudah pudar. Penyok kecil di dasar botol.', '0857-1122-3344'],

            ['Flashdisk 32GB', 'Elektronik', 'Laboratorium Jaringan', 'Fakultas Teknik', 9,
             'Merek SanDisk warna merah. Tutupnya hilang. Berisi folder bernama skripsi-bab-3.', null],

            ['Dompet kartu abu-abu', 'Dompet', 'Gedung KPLT lantai 1', 'Fakultas Teknik', 12,
             'Bahan kanvas, resleting macet di tengah. Berisi tiga kartu dan selembar foto ukuran 3x4.', null],

            ['Jam tangan digital', 'Elektronik', 'Masjid Mujahidin', 'Fakultas Ilmu Pendidikan', 4,
             'Merek Casio hitam. Tali bagian bawah pernah diganti dan warnanya sedikit berbeda.', null],
        ];

        foreach ($rows as [$name, $category, $location, $faculty, $daysAgo, $traits, $contact]) {
            $foundAt = Carbon::today()->subDays($daysAgo);
            $route   = Item::routeForCategory($category);

            Item::create([
                'name'           => $name,
                'category'       => $category,
                'location'       => $location,
                'faculty'        => $faculty,
                'found_at'       => $foundAt,
                'route'          => $route,
                'finder_contact' => $route === 'penemu' ? $contact : null,
                'hidden_traits'  => $traits,
                'status'         => 'aktif',
                'expires_at'     => $foundAt->copy()->addDays(Item::lifespanForCategory($category)),
            ]);
        }
    }
}
