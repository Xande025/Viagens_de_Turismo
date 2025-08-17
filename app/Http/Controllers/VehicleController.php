<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of vehicles (RF02)
     */
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')->paginate(10);
        
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Veículos', 'url' => '']
        ];

        return view('vehicles.index', compact('vehicles', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new vehicle
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Veículos', 'url' => route('vehicles.index')],
            ['title' => 'Novo Veículo', 'url' => '']
        ];

        return view('vehicles.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created vehicle
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate' => 'required|string|max:10|unique:vehicles',
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'capacity' => 'required|integer|min:1|max:100',
            'status' => 'required|in:available,in_use,maintenance',
            'description' => 'nullable|string|max:1000'
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }

    /**
     * Display the specified vehicle
     */
    public function show(Vehicle $vehicle)
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Veículos', 'url' => route('vehicles.index')],
            ['title' => $vehicle->plate, 'url' => '']
        ];

        return view('vehicles.show', compact('vehicle', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified vehicle
     */
    public function edit(Vehicle $vehicle)
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Veículos', 'url' => route('vehicles.index')],
            ['title' => $vehicle->plate, 'url' => route('vehicles.show', $vehicle)],
            ['title' => 'Editar', 'url' => '']
        ];

        return view('vehicles.edit', compact('vehicle', 'breadcrumbs'));
    }

    /**
     * Update the specified vehicle
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'plate' => 'required|string|max:10|unique:vehicles,plate,' . $vehicle->id,
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'capacity' => 'required|integer|min:1|max:100',
            'status' => 'required|in:available,in_use,maintenance',
            'description' => 'nullable|string|max:1000'
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Veículo atualizado com sucesso!');
    }

    /**
     * Remove the specified vehicle
     */
    public function destroy(Vehicle $vehicle)
    {
        // Verificar se o veículo tem viagens associadas
        if ($vehicle->trips()->count() > 0) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Não é possível excluir este veículo pois possui viagens associadas.');
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Veículo excluído com sucesso!');
    }
}
