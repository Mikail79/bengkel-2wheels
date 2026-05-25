<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Suplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_suplier', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('sales', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_suplier' => 'required|string|unique:supliers,id_suplier',
            'nama'       => 'required|string|max:255',
            'alamat'     => 'nullable|string',
            'sales'      => 'nullable|string|max:255',
        ]);

        Suplier::create($validated);

        return redirect()->route('suppliers')->with('success', 'Supplier added.');
    }

    public function update(Request $request, string $id)
    {
        $suplier = Suplier::findOrFail($id);

        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'sales'  => 'nullable|string|max:255',
        ]);

        $suplier->update($validated);

        return redirect()->route('suppliers')->with('success', 'Supplier updated.');
    }

    public function destroy(string $id)
    {
        Suplier::findOrFail($id)->delete();
        return redirect()->route('suppliers')->with('success', 'Supplier deleted.');
    }
}
