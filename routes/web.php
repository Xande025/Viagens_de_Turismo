<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return redirect('/login');
});

// Rota de dashboard (pós-autenticação)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas protegidas por autenticação
Route::middleware(['auth', 'check.first.access'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Recursos principais (RF01, RF02, RF03, RF04)
    Route::resource('vehicles', VehicleController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('trips', TripController::class);
    Route::resource('users', UserController::class);
    
    // Rota extra para reset de senha de usuários
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
        ->name('users.reset-password');
});

// Rotas para mudança de senha no primeiro acesso (RF06)
Route::middleware('auth')->group(function () {
    Route::get('/change-password', function () {
        return view('auth.change-password');
    })->name('password.change');
    
    Route::post('/change-password', function (Illuminate\Http\Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Senha atual incorreta.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        $user->markPasswordChanged();

        return redirect()->route('home')->with('success', 'Senha alterada com sucesso!');
    })->name('password.update');
    
    // Rota adicional para reset de senha de usuário
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});
