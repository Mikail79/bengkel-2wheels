<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('data/master_barang.csv');

        if (!file_exists($csvPath)) {
            $this->command->error("CSV file not found at: {$csvPath}");
            Log::error("BarangSeeder failed: CSV file not found at {$csvPath}");
            return;
        }

        $file = fopen($csvPath, 'r');
        if (!$file) {
            $this->command->error("Failed to open CSV file.");
            return;
        }

        // Read the first line to skip headers
        fgetcsv($file);

        $counter = 1;
        $successCount = 0;
        $errorCount = 0;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($file)) !== false) {
                // Ensure the row has exactly 4 columns as per the CSV format: nama, jenis, stok, harga_jual
                if (count($row) !== 4) {
                    Log::warning("BarangSeeder: Skipping invalid row (expected 4 columns): " . json_encode($row));
                    $errorCount++;
                    continue;
                }

                $nama = trim($row[0]);
                $jenis = trim($row[1]);
                $stok = (int) trim($row[2]);
                $harga_jual = (int) trim($row[3]);

                // Generate custom incremental ID (e.g., BRG-001, BRG-010, BRG-100)
                $id_barang = 'BRG-' . str_pad($counter, 3, '0', STR_PAD_LEFT);

                // Insert or update the record
                Barang::updateOrCreate(
                    ['id_barang' => $id_barang],
                    [
                        'nama'       => $nama,
                        'jenis'      => $jenis,
                        'stok'       => $stok,
                        'harga_beli' => 0, // Explicit default
                        'harga_jual' => $harga_jual,
                        'diskon'     => 0, // Explicit default
                    ]
                );

                $counter++;
                $successCount++;
            }

            DB::commit();
            $this->command->info("BarangSeeder completed successfully. Imported {$successCount} records. Skipped/Errors: {$errorCount}.");
            Log::info("BarangSeeder completed: {$successCount} inserted, {$errorCount} errors.");

        } catch (Exception $e) {
            DB::rollBack();
            $this->command->error("An error occurred while seeding barangs. Transaction rolled back.");
            $this->command->error($e->getMessage());
            Log::error("BarangSeeder failed with exception: " . $e->getMessage());
        } finally {
            fclose($file);
        }
    }
}
