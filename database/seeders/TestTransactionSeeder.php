<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetailNota;
use App\Models\Motor;
use App\Models\Nota;
use App\Models\Petugas;
use Illuminate\Database\Seeder;

class TestTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure prerequisite data exists
        Customer::firstOrCreate(
            ['id_customer' => 'CUST-001'],
            ['nama' => 'Budi Santoso', 'kontak' => '081234567890']
        );

        Motor::firstOrCreate(
            ['nopol' => 'B 1234 XYZ'],
            ['id_customer' => 'CUST-001']
        );

        Petugas::firstOrCreate(
            ['id_petugas' => 'MKN-001'],
            ['nama' => 'Andi Mekanik', 'jabatan' => 'Mekanik']
        );

        Barang::firstOrCreate(
            ['id_barang' => 'OLI-001'],
            ['nama' => 'Oli Yamalube 1L', 'jenis' => 'Part', 'stok' => 60, 'harga_beli' => 45000, 'harga_jual' => 65000, 'diskon' => 0]
        );

        Barang::firstOrCreate(
            ['id_barang' => 'JSA-001'],
            ['nama' => 'Ganti Oli + Tune Up', 'jenis' => 'Jasa', 'stok' => 0, 'harga_beli' => 0, 'harga_jual' => 75000, 'diskon' => 0]
        );

        // Create a sample Nota
        $nota = Nota::firstOrCreate(
            ['id_nota' => 'NT-20260528-001'],
            [
                'tanggal'            => now(),
                'total_jumlah'       => 205000,
                'nopol'              => 'B 1234 XYZ',
                'id_petugas_admin'   => 'ADM-001',
                'id_petugas_mekanik' => 'MKN-001',
            ]
        );

        // Create detail line items
        DetailNota::firstOrCreate(
            ['id_nota' => 'NT-20260528-001', 'id_barang' => 'OLI-001'],
            ['banyaknya' => 2, 'sub_total' => 130000]
        );

        DetailNota::firstOrCreate(
            ['id_nota' => 'NT-20260528-001', 'id_barang' => 'JSA-001'],
            ['banyaknya' => 1, 'sub_total' => 75000]
        );
    }
}
