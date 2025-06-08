<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClienteAuthController extends Controller
{
    public function showRegister()
    {
        return view('cliente.register'); // seu formulário
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $cliente = Cliente::create([
            'nome' => $request->name, // <-- corrigido aqui
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('cliente')->login($cliente);

        return redirect()->route('cliente.login')->with('success', 'Cadastro realizado com sucesso!');
    }
}
