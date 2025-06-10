<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class CoopControler extends Controller
{
    // Middleware para proteger rotas administrativas
    public function __construct()
    {
        // Apenas usuários autenticados podem acessar métodos sensíveis
        $this->middleware('auth')->except(['Home', 'Login', 'loginPost', 'register', 'registerPost']);
    }

    // Função para exibir a home com produtos
    public function Home()
    {
        $produtos = Product::all();
        return view('home.Home', compact('produtos'));
    }

    public function Login() { return view('sigin.loginAdm'); }
    public function Finalizar() { return view('Finalizar.finalizar'); }
    public function Entrega() { return view('Entrega.entrega'); }
    public function Pagamento() { return view('Pagamento.pagamento'); }
    public function create() { return view('admin.products.create'); }
    public function Endereco() { return view('Endereco.endereco'); }
    public function Retirada() { return view('Retirada.retirada'); }


}