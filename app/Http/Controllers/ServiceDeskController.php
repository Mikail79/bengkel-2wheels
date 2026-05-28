<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\DetailNota;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Motor;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceDeskController extends Controller
{
    public function index()
    {
        $mekaniks = Petugas::where('jabatan', 'Mekanik')->get();
        $admins   = Petugas::where('jabatan', 'Admin')->get();
        $barangs  = Barang::orderBy('nama')->get();

        return view('service-desk.index', compact('mekaniks', 'admins', 'barangs'));
    }

    /**
     * API: Search customers with their motors
     */
    public function searchCustomer(Request $request)
    {
        $q = $request->input('q', '');
        $customers = Customer::with('motors')
            ->where('nama', 'like', "%{$q}%")
            ->orWhere('id_customer', 'like', "%{$q}%")
            ->orWhereHas('motors', function ($query) use ($q) {
                $query->where('nopol', 'like', "%{$q}%");
            })
            ->limit(15)
            ->get();

        return response()->json($customers);
    }

    /**
     * API: Search items/barang
     */
    public function searchBarang(Request $request)
    {
        $q = $request->input('q', '');
        $items = Barang::where('nama', 'like', "%{$q}%")
            ->orWhere('id_barang', 'like', "%{$q}%")
            ->limit(20)
            ->get();

        return response()->json($items);
    }

    /**
     * Store a new Nota transaction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nopol'              => 'required|string|exists:motors,nopol',
            'id_petugas_admin'   => 'required|string|exists:petugas,id_petugas',
            'id_petugas_mekanik' => 'nullable|string|exists:petugas,id_petugas',
            'items'              => 'required|array|min:1',
            'items.*.id_barang'  => 'required|string|exists:barangs,id_barang',
            'items.*.banyaknya'  => 'required|integer|min:1',
        ]);

        // Generate Nota ID
        $today = now();
        $count = Nota::whereDate('tanggal', $today)->count() + 1;
        $idNota = 'NT-' . $today->format('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        // Calculate totals
        $totalJumlah = 0;
        $lineItems = [];

        foreach ($validated['items'] as $item) {
            $barang = Barang::find($item['id_barang']);
            $hargaEfektif = $barang->harga_jual - ($barang->harga_jual * $barang->diskon / 100);
            $subTotal = $hargaEfektif * $item['banyaknya'];
            $totalJumlah += $subTotal;

            $lineItems[] = [
                'id_barang' => $item['id_barang'],
                'banyaknya' => $item['banyaknya'],
                'sub_total' => $subTotal,
            ];

            // Decrease stock for Parts
            if ($barang->jenis === 'Part') {
                $barang->decrement('stok', $item['banyaknya']);
            }
        }

        // Create Nota
        $nota = Nota::create([
            'id_nota'            => $idNota,
            'tanggal'            => $today,
            'total_jumlah'       => $totalJumlah,
            'nopol'              => $validated['nopol'],
            'id_petugas_admin'   => $validated['id_petugas_admin'],
            'id_petugas_mekanik' => $validated['id_petugas_mekanik'] ?? null,
        ]);

        // Create detail items
        foreach ($lineItems as $line) {
            $nota->details()->create($line);
        }

        return response()->json([
            'success'  => true,
            'id_nota'  => $idNota,
            'total'    => $totalJumlah,
        ]);
    }

    /**
     * Display a printable thermal receipt for a specific Nota.
     */
    public function cetakStruk(string $id)
    {
        $nota = Nota::with([
            'details.barang',
            'motor.customer',
            'admin',
            'mekanik',
        ])->findOrFail($id);

        return view('cetak-struk', compact('nota'));
    }
}
