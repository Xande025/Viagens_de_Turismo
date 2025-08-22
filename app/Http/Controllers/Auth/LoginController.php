<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
        // Se for primeiro acesso, mostrar modal na página de login
        if ($user->isFirstAccess()) {
            // Fazer logout temporário para manter na tela de login
            auth()->logout();
            return redirect()->route('login')
                ->with('show_password_modal', true)
                ->with('temp_user_data', [
                    'email' => $user->email,
                    'id' => $user->id
                ]);
        }

        return redirect()->intended($this->redirectTo);
    }

    /**
     * Mudança de senha no primeiro acesso via modal
     */
    public function changePasswordFirstAccess(Request $request)
    {
        $request->validate([
            'temp_user_id' => 'required|exists:users,id',
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($request->temp_user_id);
        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('login')
                ->with('show_password_modal', true)
                ->with('temp_user_data', [
                    'email' => $user->email,
                    'id' => $user->id
                ])
                ->withErrors(['current_password' => 'Senha atual incorreta.']);
        }

        // Atualizar senha e marcar como não sendo primeiro acesso
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        $user->markPasswordChanged();

        // Fazer login automático do usuário
        auth()->login($user);

        return redirect()->intended($this->redirectTo)
            ->with('success', 'Senha alterada com sucesso! Bem-vindo ao sistema.');
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request)
    {
        auth()->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Logout realizado com sucesso!');
    }
}
