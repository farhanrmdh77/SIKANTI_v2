<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Tambahkan ini untuk memanggil Schema

class SubbagianSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan sementara pengecekan Foreign Key
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel
        DB::table('subbagians')->truncate();

        // 3. Masukkan data
        DB::table('subbagians')->insert([
            [
                'nama_subbag' => 'SDM',
                'kode_klasifikasi' => 'KP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_subbag' => 'Keuangan',
                'kode_klasifikasi' => 'KU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_subbag' => 'Hukum',
                'kode_klasifikasi' => 'HK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_subbag' => 'Humas dan TU Kalan',
                'kode_klasifikasi' => 'HM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_subbag' => 'Umum & IT',
                'kode_klasifikasi' => 'UM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. Nyalakan kembali pengecekan Foreign Key agar database kembali aman
        Schema::enableForeignKeyConstraints();
    }
}