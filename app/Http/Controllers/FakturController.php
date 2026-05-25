<?php

namespace App\Http\Controllers;

use App\Models\Faktur;
use App\Models\DetailFaktur;
use App\Models\Barang;
use App\Models\Suplier;
use App\Models\Petugas;
use Illuminate\Http\Request;

class FakturController extends Controller
{
    public function index(Request $request)
    {
        $supliers = Suplier::orderBy('nama')->get();
        $petugas  = Petugas::where('jabatan', 'Admin')->get();
        $barangs  = Barang::where('jenis', 'Part')->orderBy('nama')->get();

        // Get all fakturs with suplier and petugas relations
        $fakturs = Faktur::with(['suplier', 'petugas'])->orderBy('created_at', 'desc')->get();

        return view('inbound-po.index', compact('supliers', 'petugas', 'barangs', 'fakturs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_faktur'         => 'nullable|string|max:255',
            'id_suplier'        => 'required|string|exists:supliers,id_suplier',
            'id_petugas'        => 'required|string|exists:petugas,id_petugas',
            'tanggal'           => 'required|date',
            'termin'            => 'nullable|string|max:255',
            'syarat_pembayaran' => 'nullable|string|max:255',
            'diskon'            => 'nullable|integer|min:0',
            'ppn'               => 'nullable|integer|min:0',
            'items'             => 'required|array|min:1',
            'items.*.id_barang' => 'required|string|exists:barangs,id_barang',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.harga_beli'=> 'required|integer|min:0',
        ]);

        $today = now();
        $count = Faktur::whereDate('created_at', $today)->count() + 1;
        $idFaktur = 'FK-' . $today->format('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $subTotal = 0;
        $lineItems = [];

        foreach ($validated['items'] as $item) {
            $barang = Barang::find($item['id_barang']);
            $totalHarga = $item['harga_beli'] * $item['qty'];
            $subTotal += $totalHarga;

            $lineItems[] = [
                'id_barang'   => $item['id_barang'],
                'qty'         => $item['qty'],
                'total_harga' => $totalHarga,
            ];

            // Inbound PO increments stock
            $barang->increment('stok', $item['qty']);
            
            // Update the purchase price to current inbound price
            $barang->update(['harga_beli' => $item['harga_beli']]);
        }

        $diskon = $validated['diskon'] ?? 0;
        $ppn = $validated['ppn'] ?? 0;
        $total = $subTotal - $diskon + $ppn;

        $faktur = Faktur::create([
            'id_faktur'         => $idFaktur,
            'no_faktur'         => $validated['no_faktur'],
            'id_suplier'        => $validated['id_suplier'],
            'id_petugas'        => $validated['id_petugas'],
            'tanggal'           => $validated['tanggal'],
            'termin'            => $validated['termin'],
            'syarat_pembayaran' => $validated['syarat_pembayaran'],
            'sub_total'         => $subTotal,
            'diskon'            => $diskon,
            'ppn'               => $ppn,
            'total'             => $total,
        ]);

        foreach ($lineItems as $line) {
            $faktur->details()->create($line);
        }

        return response()->json([
            'success'   => true,
            'id_faktur' => $idFaktur,
            'total'     => $total,
        ]);
    }
}
