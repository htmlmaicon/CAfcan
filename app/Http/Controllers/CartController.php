<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cartItems as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity']
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);
        $currentInCart = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        $totalRequested = $currentInCart + $request->quantity;

        if ($totalRequested > $product->quantity) {
            return back()->with('error', 'Quantidade solicitada maior que o estoque disponível!');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $request->quantity
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produto removido do carrinho!');
    }
}
