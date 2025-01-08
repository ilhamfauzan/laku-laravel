<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    // Display a listing of the services
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    // Show the form for creating a new service
    public function create()
    {
        return view('services.create');
    }

    // Store a newly created service in storage
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric',
        ]);

        Service::create([
            'service_name' => $request->service_name,
            'service_price' => $request->service_price,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('services')->with('success', 'Service created successfully.');
    }

    // Display the specified service
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    // Show the form for editing the specified service
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    // Update the specified service in storage
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric',
        ]);

        $service->update($request->all());

        return redirect()->route('services')->with('success', 'Service updated successfully.');
    }

    // Remove the specified service from storage
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services')->with('delete', 'Service deleted successfully.');
    }
}