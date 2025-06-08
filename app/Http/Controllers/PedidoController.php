<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function __construct()
    {
        // Garante que só clientes autenticados podem acessar os pedidos
        $this->middleware('auth:cliente');
    }

    public function index()
    {
        $cliente = auth('cliente')->user();

        // Protege contra acesso indevido
        if (!$cliente) {
            abort(403, 'Acesso não autorizado.');
        }

        // Busca apenas pedidos do cliente autenticado
        $pedidos = Pedido::where('cliente_id', $cliente->id)->latest()->get();

        // Decodifica apenas se não for array
        foreach ($pedidos as $pedido) {
            if (!is_array($pedido->produtos)) {
                $pedido->produtos = json_decode($pedido->produtos, true);
            }
        }

        return view('pedidos.index', compact('pedidos'));
    }
}