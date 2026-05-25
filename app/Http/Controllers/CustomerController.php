<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Motor;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('motors');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_customer', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_customer' => 'required|string|unique:customers,id_customer',
            'nama'        => 'required|string|max:255',
            'kontak'      => 'required|string|max:255',
        ]);

        $customer = Customer::create($validated);

        // Handle motors if provided
        if ($request->filled('nopol')) {
            $nopols = array_filter($request->input('nopol', []));
            foreach ($nopols as $nopol) {
                Motor::create([
                    'nopol'       => $nopol,
                    'id_customer' => $customer->id_customer,
                ]);
            }
        }

        return redirect()->route('customers')->with('success', 'Customer added.');
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
        ]);

        $customer->update($validated);

        return redirect()->route('customers')->with('success', 'Customer updated.');
    }

    public function destroy(string $id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customers')->with('success', 'Customer deleted.');
    }

    /**
     * API endpoint: return customers as JSON for AJAX select
     */
    public function search(Request $request)
    {
        $q = $request->input('q', '');
        $customers = Customer::with('motors')
            ->where('nama', 'like', "%{$q}%")
            ->orWhere('id_customer', 'like', "%{$q}%")
            ->limit(20)
            ->get();

        return response()->json($customers);
    }
}
