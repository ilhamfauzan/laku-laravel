<?php

namespace App\Http\Controllers;

use App\Models\Laundry;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LaundryController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $laundries = Laundry::where('user_id', Auth::user()->id)->get();
        $services = Service::all();
        // dd($services);
        return view('laundries.index', compact('laundries', 'services'));
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
            'status' => 'required|in:Unfinished,Finished',
            'service_id' => 'required|exists:services,id',
        ]);

        $laundry = new Laundry($request->all());
        $laundry->user_id = Auth::user()->id;
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
            'status' => 'required|in:Unfinished,Finished',
            'service_id' => 'required|exists:services,id',
        ]);

        $laundry->update($request->all());

        return redirect()->route('laundries.index')->with('success', 'Laundry updated successfully.');
    }

    public function destroy(Laundry $laundry)
    {
        $this->authorize('delete', $laundry);
        $laundry->delete();

        return redirect()->route('laundries.index')->with('success', 'Laundry deleted successfully.');
    }
}
