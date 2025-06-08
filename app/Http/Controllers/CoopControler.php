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

    // Login com validação
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:6', 'max:100']
        ]);

        // Limita tentativas de login para evitar brute force
        if (method_exists($request, 'hasTooManyLoginAttempts') && $request->hasTooManyLoginAttempts($request)) {
            return back()->withErrors(['email' => 'Muitas tentativas. Tente novamente mais tarde.'])->withInput();
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('products.create');
        }

        // Incrementa tentativas de login
        if (method_exists($request, 'incrementLoginAttempts')) {
            $request->incrementLoginAttempts($request);
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos.',
        ])->withInput();
    }

    // Registro de novo usuário
    public function register()
    {
        return view('sigin.registerAdm');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:100|confirmed'
        ]);

        // Sanitização básica
        $name = strip_tags($request->name);
        $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Conta criada com sucesso! Faça login.');
    }

    // Logout seguro
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}