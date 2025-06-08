@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
    <div class="content">
        <h1 class="my-4">Nossos Produtos</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="product-grid">
            @foreach ($produtos as $produto)
                <div class="product-card">
                    <div class="product-image-container">
                        @if($produto->image)
                            <img src="{{ asset('storage/' . $produto->image) }}" 
                                 class="product-image" 
                                 alt="{{ $produto->name }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-leaf"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="product-body">
                        <h3 class="product-title">{{ $produto->name }}</h3>
                        <p class="product-description">{{ $produto->description }}</p>
                        
                        <div class="product-footer">
                            <span class="product-price">R$ {{ number_format($produto->price, 2, ',', '.') }}</span>
                            <span class="product-category">{{ ucfirst($produto->category) }}</span>
                        </div>

                        <p class="product-stock">
                            <strong>Estoque:</strong> {{ $produto->quantity }}
                        </p>
                        
                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $produto->id }}">
                            <div class="input-group">
                                <input type="number" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $produto->quantity }}"
                                       class="quantity-input"
                                       aria-label="Quantidade"
                                       @if($produto->quantity < 1) disabled @endif
                                >
                                <button type="submit" class="add-to-cart-btn" @if($produto->quantity < 1) disabled @endif>
                                    <i class="fas fa-cart-plus"></i> Adicionar
                                </button>
                            </div>
                            @if($produto->quantity < 1)
                                <small class="text-danger">Produto esgotado</small>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if($produtos->isEmpty())
            <div class="alert alert-info">Nenhum produto cadastrado ainda.</div>
        @endif
    </div>
@endsection