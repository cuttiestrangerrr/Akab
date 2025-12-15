<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function show(Service $service)
    {
        // Increment view count
        $service->increment('views_count');
        
        // Track user category preference
        \App\Http\Controllers\HomeController::trackPreference($service->kategori);
        
        return view('service.detail', compact('service'));
    }

    public function index()
    {
        $services = Auth::user()->services;
        return view('developer.manage_services', compact('services'));
    }

    public function create()
    {
        return view('uploadJasaDev');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Add-ons validation can be added here if we implement logic for it
        ]);

        $path = $request->file('gambar')->store('services', 'public');

        // We use 'harga_mulai' as a base price. 
        // For now, let's assume a default or get it from input if available. 
        // If the view doesn't send 'harga_mulai', we'll default it or extract from addons logic later.
        // The view "uploadJasaDev" seems to have "harga" in add-ons but not a main price?
        // Let's check the view again. It has add-ons but maybe we need a base price input?
        // Ah, the view is a bit complex with add-ons. 
        // For simple CRUD compliance with `Service` model, I'll assume we add a hidden or explicit price input
        // or just pick the first addon price or a default. 
        // Let's add 'harga_mulai' to the view or request.
        
        // TEMPORARY FIX: Start price from 0 or requiring an input.
        // Viewing the previous view `uploadJasaDev.blade.php`, it didn't have a main "Price" field, only addons.
        // I should update the view to include a "Starting Price" field.
        
        $price = $request->input('harga_mulai', 0); 
        $addons = $request->input('addons') ? json_decode($request->input('addons'), true) : [];

        Auth::user()->services()->create([
            'judul' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'harga_mulai' => $price,
            'thumbnail' => $path,
            'addons' => $addons,
        ]);

        return redirect()->route('developer.services.index')->with('success', 'Jasa berhasil diupload!');
    }

    public function edit(Service $service)
    {
        // Ensure ownership
        if ($service->id_developer !== Auth::id()) {
            abort(403);
        }
        return view('uploadJasaDev', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        if ($service->id_developer !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('services', 'public');
            $service->thumbnail = $path;
        }

        $service->update([
            'judul' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'addons' => $request->input('addons') ? json_decode($request->input('addons'), true) : $service->addons,
            'harga_mulai' => $request->input('harga_mulai', $service->harga_mulai),
        ]);

        return redirect()->route('developer.services.index')->with('success', 'Jasa berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        if ($service->id_developer !== Auth::id()) {
            abort(403);
        }

        $service->delete();
        return redirect()->route('developer.services.index')->with('success', 'Jasa berhasil dihapus.');
    }
}
