<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->get();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_polisi' => 'required|unique:cars',
            'merk' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status_mobil' => 'nullable|in:tersedia,tidak tersedia' // <-- Tambahkan ini
        ]);

        // Jika status tidak diisi saat tambah, otomatis jadikan 'tersedia'
        if (!isset($validated['status_mobil'])) {
            $validated['status_mobil'] = 'tersedia';
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('cars', 'public');
            $validated['foto'] = $path;
        }

        Car::create($validated);
        return redirect()->route('cars.index')->with('success', 'Data mobil berhasil ditambahkan.');
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'no_polisi' => 'required|unique:cars,no_polisi,' . $car->id,
            'merk' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status_mobil' => 'required|in:tersedia,tidak tersedia' // <-- Tambahkan ini
        ]);

        if ($request->hasFile('foto')) {
            if ($car->foto) Storage::disk('public')->delete($car->foto);
            $path = $request->file('foto')->store('cars', 'public');
            $validated['foto'] = $path;
        }

        $car->update($validated);
        return redirect()->route('cars.index')->with('success', 'Data mobil berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        if ($car->foto) Storage::disk('public')->delete($car->foto);
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Data mobil berhasil dihapus.');
    }
}