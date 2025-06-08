 
@extends('layouts.app')

@section('title', 'Carrinho de Compras')

@section('content')
<div class="cart-container">
    <h1 class="my-4">Seu Carrinho</h1>

    @if(count($products) == 0)
        <div class="empty-cart">
            <div class="alert alert-info">Seu carrinho está vazio.</div>
            <a href="{{ route('home') }}" class="btn btn-continue">
                <i class="fas fa-arrow-left"></i> Continuar Comprando
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div class="cart-product-info">
                                @if($product['image'])
                                    <img src="{{ asset('storage/' . $product['image']) }}" class="cart-product-image" alt="{{ $product['name'] }}">
                                @else
                                    <div class="cart-product-image no-image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <span>{{ $product['name'] }}</span>
                            </div>
                        </td>
                        <td>R$ {{ number_format($product['price'], 2, ',', '.') }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>R$ {{ number_format($product['subtotal'], 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $product['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="cart-btn btn-danger">
                                    <i class="fas fa-trash"></i> Remover
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="cart-total">Total</td>
                        <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="cart-footer">
            <a href="{{ route('home') }}" class="cart-btn btn-continue">
                <i class="fas fa-arrow-left"></i> Continuar Comprando
            </a>
            @auth('cliente')
                <a href="{{ route('retirada') }}" class="cart-btn btn-checkout">
                    <i class="fas fa-credit-card"></i> Finalizar Compra
                </a>
            @else
                <div class="alert alert-warning">
                    Você precisa <a href="{{ route('cliente.login') }}">fazer login</a> para finalizar a compra.
                </div>
            @endauth
        </div>
    @endif
</div>
@endsection