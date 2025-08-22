<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users (RF04)
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        
        $breadcrumbs = [
            ['title' => 'Usuários', 'url' => '']
        ];

        return view('users', compact('users', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => 'Usuários', 'url' => route('users.index')],
            ['title' => 'Novo Usuário', 'url' => '']
        ];

        return view('users.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Gerar senha temporária para primeiro acesso
        $tempPassword = 'temp' . rand(1000, 9999);
        
        $validated['password'] = Hash::make($tempPassword);
        $validated['first_access'] = true;

        $user = User::create($validated);

        return redirect()->route('users.index')
            ->with('success', "Usuário criado com sucesso! Senha temporária: <strong>{$tempPassword}</strong><br><small>Informe esta senha ao usuário. Ele deverá alterá-la no primeiro login.</small>");
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $breadcrumbs = [
            ['title' => 'Usuários', 'url' => route('users.index')],
            ['title' => $user->name, 'url' => '']
        ];

        return view('users.show', compact('user', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $breadcrumbs = [
            ['title' => 'Usuários', 'url' => route('users.index')],
            ['title' => $user->name, 'url' => route('users.show', $user)],
            ['title' => 'Editar', 'url' => '']
        ];

        return view('users.edit', compact('user', 'breadcrumbs'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user)
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy(User $user)
    {
        // Não permitir exclusão do próprio usuário logado
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Não é possível excluir seu próprio usuário.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Reset user password (RF05)
     */
    public function resetPassword(User $user)
    {
        // Não permitir reset da própria senha
        if ($user->id === auth()->id()) {
            return redirect()->route('users.show', $user)
                ->with('error', 'Não é possível resetar sua própria senha. Use a opção "Alterar Senha" no menu.');
        }

        // Gerar nova senha temporária
        $tempPassword = 'temp' . rand(1000, 9999);
        
        $user->update([
            'password' => Hash::make($tempPassword),
            'first_access' => true,
            'password_changed_at' => null
        ]);

        return redirect()->route('users.show', $user)
            ->with('success', "Senha resetada com sucesso. Nova senha temporária: <strong>{$tempPassword}</strong><br><small>Informe esta senha ao usuário. Ele deverá alterá-la no primeiro login.</small>")
            ->with('temp_password', $tempPassword);
    }
}