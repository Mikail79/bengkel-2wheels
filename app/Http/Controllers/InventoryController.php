<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display the inventory data grid.
     */
    public function index(Request $request)
    {
        $query = Barang::query();

        // Filter by type
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_barang', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $barangs = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Stats
        $countParts = Barang::where('jenis', 'Part')->count();
        $countJasa  = Barang::where('jenis', 'Jasa')->count();
        $lowStock   = Barang::where('jenis', 'Part')->where('stok', '<=', 5)->count();

        return view('inventory.index', compact('barangs', 'countParts', 'countJasa', 'lowStock'));
    }

    /**
     * Store a newly created inventory item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang'  => 'required|string|unique:barangs,id_barang',
            'nama'       => 'required|string|max:255',
            'jenis'      => 'required|in:Part,Jasa',
            'stok'       => 'nullable|integer|min:0',
            'harga_beli' => 'nullable|integer|min:0',
            'harga_jual' => 'nullable|integer|min:0',
            'diskon'     => 'nullable|integer|min:0|max:100',
        ]);

        Barang::create($validated);

        return redirect()->route('inventory')->with('success', 'Item added successfully.');
    }

    /**
     * Update the specified inventory item.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'jenis'      => 'required|in:Part,Jasa',
            'stok'       => 'nullable|integer|min:0',
            'harga_beli' => 'nullable|integer|min:0',
            'harga_jual' => 'nullable|integer|min:0',
            'diskon'     => 'nullable|integer|min:0|max:100',
        ]);

        $barang->update($validated);

        return redirect()->route('inventory')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified inventory item.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('inventory')->with('success', 'Item deleted successfully.');
    }
}
