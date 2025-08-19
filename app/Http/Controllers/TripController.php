<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of trips (RF01)
     */
    public function index()
    {
        $trips = Trip::with(['vehicle', 'driver'])
            ->orderBy('departure_time', 'desc')
            ->paginate(10);
        
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Viagens', 'url' => '']
        ];

        return view('trips.index', compact('trips', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new trip
     */
    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        $drivers = Driver::where('status', 'active')
            ->whereDate('cnh_expiry', '>', now())
            ->get();
        
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Viagens', 'url' => route('trips.index')],
            ['title' => 'Nova Viagem', 'url' => '']
        ];

        return view('trips.create', compact('vehicles', 'drivers', 'breadcrumbs'));
    }

    /**
     * Store a newly created trip
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'passenger_count' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'description' => 'nullable|string|max:1000',
            'observations' => 'nullable|string|max:1000'
        ]);

        // Verificar se veículo tem capacidade suficiente
        $vehicle = Vehicle::find($validated['vehicle_id']);
        if ($validated['passenger_count'] > $vehicle->capacity) {
            return back()->withErrors([
                'passenger_count' => 'O número de passageiros excede a capacidade do veículo (' . $vehicle->capacity . ')'
            ])->withInput();
        }

        // Verificar conflitos de horário para veículo e motorista
        $conflicts = Trip::where(function($query) use ($validated) {
                $query->where('vehicle_id', $validated['vehicle_id'])
                      ->orWhere('driver_id', $validated['driver_id']);
            })
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('departure_time', [$validated['departure_time'], $validated['arrival_time']])
                      ->orWhereBetween('arrival_time', [$validated['departure_time'], $validated['arrival_time']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('departure_time', '<=', $validated['departure_time'])
                            ->where('arrival_time', '>=', $validated['arrival_time']);
                      });
            })
            ->exists();

        if ($conflicts) {
            return back()->withErrors([
                'departure_time' => 'Existe conflito de horário com o veículo ou motorista selecionado.'
            ])->withInput();
        }

        Trip::create($validated);

        return redirect()->route('trips.index')
            ->with('success', 'Viagem cadastrada com sucesso!');
    }

    /**
     * Display the specified trip
     */
    public function show(Trip $trip)
    {
        $trip->load(['vehicle', 'driver']);
        
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Viagens', 'url' => route('trips.index')],
            ['title' => $trip->origin . ' → ' . $trip->destination, 'url' => '']
        ];

        return view('trips.show', compact('trip', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified trip
     */
    public function edit(Trip $trip)
    {
        $vehicles = Vehicle::where('status', 'available')
            ->orWhere('id', $trip->vehicle_id)
            ->get();
        $drivers = Driver::where('status', 'active')
            ->whereDate('cnh_expiry', '>', now())
            ->orWhere('id', $trip->driver_id)
            ->get();
        
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Viagens', 'url' => route('trips.index')],
            ['title' => $trip->origin . ' → ' . $trip->destination, 'url' => route('trips.show', $trip)],
            ['title' => 'Editar', 'url' => '']
        ];

        return view('trips.edit', compact('trip', 'vehicles', 'drivers', 'breadcrumbs'));
    }

    /**
     * Update the specified trip
     */
    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'passenger_count' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'description' => 'nullable|string|max:1000',
            'observations' => 'nullable|string|max:1000'
        ]);

        $trip->update($validated);

        return redirect()->route('trips.show', $trip)
            ->with('success', 'Viagem atualizada com sucesso!');
    }

    /**
     * Remove the specified trip
     */
    public function destroy(Trip $trip)
    {
        // Só permitir exclusão se a viagem não estiver em andamento
        if ($trip->status === 'in_progress') {
            return redirect()->route('trips.index')
                ->with('error', 'Não é possível excluir uma viagem em andamento.');
        }

        $trip->delete();

        return redirect()->route('trips.index')
            ->with('success', 'Viagem excluída com sucesso!');
    }
}
