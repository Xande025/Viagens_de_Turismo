<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of drivers (RF03)
     */
    public function index()
    {
        $drivers = Driver::orderBy('created_at', 'desc')->paginate(10);
        
        $breadcrumbs = [
            ['title' => 'Motoristas', 'url' => '']
        ];

        return view('drivers', compact('drivers', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new driver
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => 'Motoristas', 'url' => route('drivers.index')],
            ['title' => 'Novo Motorista', 'url' => '']
        ];

        return view('drivers.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created driver
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'registration' => 'nullable|string|max:50',
            'cpf' => 'nullable|string|max:20',
            'rg' => 'nullable|string|max:20',
            'zip_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
            'email' => 'nullable|email|max:255'
        ]);

        // Remove formatação do CPF se houver e verifica duplicatas apenas se preenchido
        if (!empty($validated['cpf'])) {
            $cpf_clean = preg_replace('/[^0-9]/', '', $validated['cpf']);
            
            if (!empty($cpf_clean)) {
                // Verifica se CPF já existe
                $existingDriver = Driver::where('cpf', $cpf_clean)->first();
                if ($existingDriver) {
                    return redirect()->back()
                        ->withErrors(['cpf' => 'Este CPF já está cadastrado.'])
                        ->withInput();
                }
                $validated['cpf'] = $cpf_clean;
            }
        }
        
        // Verifica se email já existe (apenas se preenchido)
        if (!empty($validated['email'])) {
            $existingEmail = Driver::where('email', $validated['email'])->first();
            if ($existingEmail) {
                return redirect()->back()
                    ->withErrors(['email' => 'Este email já está cadastrado.'])
                    ->withInput();
            }
        }
        
        // Define status padrão como ativo
        $validated['status'] = 'active';

        try {
            Driver::create($validated);
            return redirect()->route('drivers.index')
                ->with('success', 'Motorista cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erro ao cadastrar motorista: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified driver
     */
    public function show(Driver $driver)
    {
        $breadcrumbs = [
            ['title' => 'Motoristas', 'url' => route('drivers.index')],
            ['title' => $driver->name, 'url' => '']
        ];

        return view('drivers.show', compact('driver', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified driver
     */
    public function edit(Driver $driver)
    {
        $breadcrumbs = [
            ['title' => 'Motoristas', 'url' => route('drivers.index')],
            ['title' => $driver->name, 'url' => route('drivers.show', $driver)],
            ['title' => 'Editar', 'url' => '']
        ];

        return view('drivers.edit', compact('driver', 'breadcrumbs'));
    }

    /**
     * Update the specified driver
     */
    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:drivers,cpf,' . $driver->id,
            'cnh' => 'required|string|max:20|unique:drivers,cnh,' . $driver->id,
            'cnh_category' => 'required|in:A,B,C,D,E',
            'cnh_expiry' => 'required|date|after:today',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:drivers,email,' . $driver->id,
            'status' => 'required|in:active,inactive'
        ]);

        // Remove formatação do CPF se houver
        $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);

        $driver->update($validated);

        return redirect()->route('drivers.show', $driver)
            ->with('success', 'Motorista atualizado com sucesso!');
    }

    /**
     * Remove the specified driver
     */
    public function destroy(Driver $driver)
    {
        // Verificar se o motorista tem viagens associadas
        if ($driver->trips()->count() > 0) {
            return redirect()->route('drivers.index')
                ->with('error', 'Não é possível excluir este motorista pois possui viagens associadas.');
        }

        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Motorista excluído com sucesso!');
    }

    /**
     * Get driver data for edit form
     */
    public function getDriverData(Driver $driver)
    {
        return response()->json([
            'id' => $driver->id,
            'name' => $driver->name,
            'birth_date' => $driver->birth_date,
            'registration' => $driver->registration,
            'cpf' => $driver->cpf,
            'rg' => $driver->rg,
            'zip_code' => $driver->zip_code,
            'address' => $driver->address,
            'number' => $driver->number,
            'city' => $driver->city,
            'state' => $driver->state,
            'email' => $driver->email,
            'phone' => $driver->phone,
            'status' => $driver->status
        ]);
    }
}
