<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteLoginController extends Controller
{
    /**
     * Exibe o formulário de login do cliente
     */
    public function showLoginForm()
    {
        return view('cliente.login');
    }

    /**
     * Autentica o cliente usando o guard 'cliente'
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validação básica (opcional, mas recomendada)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);

        if (Auth::guard('cliente')->attempt($credentials)) {
            $request->session()->regenerate();

            // Redireciona para onde o cliente tentou acessar, ou home
            return redirect()->intended(route('home'));
        }

        // Falha no login
        return back()->withErrors([
            'email' => 'Email ou senha incorretos.',
        ])->withInput($request->only('email'));
    }

    /**
     * Faz logout do cliente
     */
    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Limpa o carrinho da sessão
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Você saiu com sucesso!');
    }
}
