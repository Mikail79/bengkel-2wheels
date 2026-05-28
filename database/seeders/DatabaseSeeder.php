<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the matching petugas (staff domain record)
        $petugas = Petugas::firstOrCreate(
            ['id_petugas' => 'ADM-001'],
            [
                'nama'    => 'Super Admin',
                'jabatan' => 'Admin',
            ]
        );

        // 2. Create the Super Admin auth account linked to the petugas
        User::firstOrCreate(
            ['email' => 'admin@2wheels.local'],
            [
                'name'       => 'Super Admin',
                'password'   => bcrypt('admin123'),
                'id_petugas' => $petugas->id_petugas,
                'role'       => 'Admin',
            ]
        );

        // 3. Call the BarangSeeder to import the CSV
        $this->call([
            BarangSeeder::class,
        ]);
    }
}
