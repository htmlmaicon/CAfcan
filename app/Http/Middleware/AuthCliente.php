<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCliente
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o cliente está autenticado com o guard 'cliente'
        if (!Auth::guard('cliente')->check()) {
            // Redireciona para a rota de login do cliente (ajuste se necessário)
            return redirect()->route('cliente.login');
        }

        return $next($request);
    }
}
