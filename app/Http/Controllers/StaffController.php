<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Petugas::query();

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_petugas', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $staff = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $countAdmin   = Petugas::where('jabatan', 'Admin')->count();
        $countMekanik = Petugas::where('jabatan', 'Mekanik')->count();

        return view('staff.index', compact('staff', 'countAdmin', 'countMekanik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_petugas' => 'required|string|unique:petugas,id_petugas',
            'nama'       => 'required|string|max:255',
            'jabatan'    => 'required|in:Admin,Mekanik',
        ]);

        Petugas::create($validated);

        return redirect()->route('staff')->with('success', 'Staff added.');
    }

    public function update(Request $request, string $id)
    {
        $petugas = Petugas::findOrFail($id);

        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|in:Admin,Mekanik',
        ]);

        $petugas->update($validated);

        return redirect()->route('staff')->with('success', 'Staff updated.');
    }

    public function destroy(string $id)
    {
        Petugas::findOrFail($id)->delete();
        return redirect()->route('staff')->with('success', 'Staff deleted.');
    }

    public function search(Request $request)
    {
        $q = $request->input('q', '');
        $jabatan = $request->input('jabatan', '');

        $query = Petugas::where('nama', 'like', "%{$q}%");
        if ($jabatan) {
            $query->where('jabatan', $jabatan);
        }

        return response()->json($query->limit(20)->get());
    }
}
