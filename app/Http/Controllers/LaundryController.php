<?php

namespace App\Http\Controllers;

use App\Models\Laundry;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LaundryController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        if ($request->keyword) {
            $laundries = Laundry::search($request->keyword)->get();
            // dd($laundries);
        } else {
            $laundries = Laundry::all();
        }
        // $laundries = Laundry::all();
        $services = Service::all();
        $transactions = Transaction::all();
        // dd($services);
        return view('laundries.index', compact('laundries', 'services', 'transactions'));
    }

    public function create()
    {
        $services = Service::all();
        return view('laundries.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone_number' => 'nullable|string|max:255',
            'laundry_weight' => 'required|numeric',
            'laundry_date' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'description' => 'nullable|string', // Add this line
        ]);

        $laundry = new Laundry($request->all());
        $laundry->user_id = Auth::user()->id;
        $laundry->status = 'Unfinished';
        $laundry->save();

        return redirect()->route('laundries.index')->with('success', 'Laundry created successfully.');
    }

    public function show(Laundry $laundry)
    {
        $this->authorize('view', $laundry);
        return view('laundries.show', compact('laundry'));
    }

    public function edit(Laundry $laundry)
    {
        $this->authorize('update', $laundry);
        $services = Service::all();
        return view('laundries.edit', compact('laundry', 'services'));
    }

    public function update(Request $request, Laundry $laundry)
    {

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone_number' => 'nullable|string|max:255',
            'laundry_weight' => 'required|numeric',
            'laundry_date' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'description' => 'nullable|string', // Add this line
        ]);

        $laundry->update($request->all());

        return redirect()->route('laundries.index')->with('success', 'Laundry updated successfully.');
    }

    public function destroy(Laundry $laundry)
    {
        // $this->authorize('delete', $laundry);
        $laundry->delete();

        return redirect()->route('laundries.index')->with('delete', 'Laundry deleted successfully.');
    }

    public function finish(Laundry $laundry)
    {
        // $this->authorize('update', $laundry);
        $laundry->status = 'Finished';
        $laundry->save();

        return redirect()->route('laundries.index')->with('success', 'Laundry marked as finished.');
    }
}
