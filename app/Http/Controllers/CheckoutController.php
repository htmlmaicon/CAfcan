<?php

 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function salvarEnderecoEntrega(Request $request)
    {
        // Permite salvar endereço apenas se o cliente estiver autenticado
        $cliente = auth('cliente')->user();

        if ($request->tipo_entrega === 'entrega' && $cliente) {
            $data = $request->validate([
                'rua' => 'required|string|max:100',
                'numero' => 'required|numeric|digits_between:1,100',
                'bairro' => 'nullable|string|max:100',
                'cep' => ['nullable', 'regex:/^\d{8}$/'], // cep com 8 dígitos numéricos
            ]);

            $cliente->endereco()->updateOrCreate(
                ['cliente_id' => $cliente->id],
                $data
            );
        }

        // Salva o tipo de entrega na sessão para uso no pagamento
        session([
            'tipo_entrega' => $request->tipo_entrega,
            'taxa_entrega' => $request->tipo_entrega === 'entrega' ? 5.00 : 0,
        ]);

        return redirect()->route('pagamento');
    }

    public function finalizarPedido(Request $request)
    {
        // Torna público: não exige autenticação
        $cliente = auth('cliente')->user();

        $cartItems = session('cart', []);
        $produtos = [];
        $total = 0;

        foreach ($cartItems as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $product->quantity = max(0, $product->quantity - $item['quantity']);
                $product->save();

                $produtos[] = [
                    'nome' => $product->name,
                    'quantidade' => $item['quantity'],
                    'preco' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        $tipo_entrega = session('tipo_entrega', 'entrega');

        // Busca o endereço do cliente se for entrega e autenticado
        $endereco = null;
        if ($tipo_entrega === 'entrega' && $cliente && $cliente->endereco) {
            $endereco = json_encode([
                'rua' => $cliente->endereco->rua,
                'numero' => $cliente->endereco->numero,
                'bairro' => $cliente->endereco->bairro,
                'cep' => $cliente->endereco->cep,
            ]);
        }

        try {
            Pedido::create([
                'cliente_id' => $cliente->id ?? null,
                'nome' => $cliente->nome ?? $request->input('nome', 'Visitante'),
                'telefone' => $cliente->telefone ?? $request->input('telefone', ''),
                'tipo_entrega' => $tipo_entrega,
                'endereco' => $endereco,
                'produtos' => json_encode($produtos),
                'pagamento' => $request->forma_pagamento,
                'total' => $total,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('pagamento')->withErrors(['erro' => 'Erro ao salvar o pedido. Tente novamente.']);
        }

        session()->forget('cart');
        session()->forget('tipo_entrega');
        session()->forget('taxa_entrega');

        return redirect()->route('pedidos.index')->with('success', 'Pedido finalizado!');
    }
}