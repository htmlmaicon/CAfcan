
@extends('layouts.main')

@section('title', 'Produtos Agrícolas')
@section('header-title', 'Nossos Produtos Fresquinhos')

@section('content')
<div class="agri-container">
    <div class="agri-list-header mb-5">
        <a href="{{ route('products.create') }}" class="agri-btn agri-btn-success ">
            Cadastrar Novo Produto
        </a>
    </div>

    <div class="agri-products-grid">
        @foreach($products as $product)
        <div class="agri-product-card">
            <div class="agri-product-image-container">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="agri-product-image" 
                         alt="{{ $product->name }}">
                @else
                    <div class="agri-product-image-placeholder">🌾</div>
                @endif
            </div>
            
            <div class="agri-product-body">
                <div class="agri-product-header">
                    <h3 class="agri-product-title">{{ $product->name }}</h3>
                    <span class="agri-product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                </div>

                <div class="agri-product-category agri-category-{{ $product->category }}">
                    @switch($product->category)
                        @case('fruta') 🍎 Fruta @break
                        @case('verdura') 🥦 Verdura @break
                        @case('congelado') 🥶 Congelado @break
                        @case('panificado') 🍞 Panificado @break
                    @endswitch
                </div>

                <p class="agri-product-description">{{ $product->description }}</p>

                <p class="agri-product-quantity">
                    <strong>Estoque:</strong> {{ $product->quantity }}
                </p>

                <div class="agri-product-actions">
                    <a href="{{ route('products.edit', $product->id) }}" 
                       class="agri-btn agri-btn-outline">
                        ✏️ Editar
                    </a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="agri-btn agri-btn-outline-danger">
                            🗑️ Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection