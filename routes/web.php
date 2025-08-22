<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('tumb');
});

// Página tumb (splash/intro)
Route::get('/tumb', function () {
    return view('tumb');
});

// Rota de dashboard (pós-autenticação)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rota específica para primeiro acesso (mudança de senha no modal) - sem middleware auth
Route::post('/change-password-first-access', [LoginController::class, 'changePasswordFirstAccess'])->name('change-password-first-access');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Redirecionar /home para /users
    Route::get('/home', function () {
        return redirect('/users');
    })->name('home');
    
    // Recursos principais (RF01, RF02, RF03, RF04)
    Route::resource('vehicles', VehicleController::class);
    Route::resource('drivers', DriverController::class);
    Route::get('/drivers/{driver}/data', [DriverController::class, 'getDriverData'])->name('drivers.data');
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
