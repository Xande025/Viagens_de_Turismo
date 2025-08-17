<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Se o usuário está logado e é o primeiro acesso
        if ($user && $user->isFirstAccess()) {
            // Só permite acesso à página de mudança de senha
            if (!$request->routeIs('password.change') && !$request->routeIs('password.update')) {
                return redirect()->route('password.change')
                    ->with('info', 'Você deve alterar sua senha no primeiro acesso.');
            }
        }

        return $next($request);
    }
}
