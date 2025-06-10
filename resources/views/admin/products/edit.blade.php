@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Editar Produto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="price">Preço:</label>
            <input type="text" name="price" id="price" value="{{ old('price', number_format($product->price, 2, ',', '')) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantidade:</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" class="form-control" min="0" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="category">Categoria:</label>
            <select name="category" id="category" class="form-control" required>
                <option value="congelado" {{ old('category', $product->category) == 'congelado' ? 'selected' : '' }}>Congelado</option>
                <option value="panificado" {{ old('category', $product->category) == 'panificado' ? 'selected' : '' }}>Panificado</option>
                <option value="fruta" {{ old('category', $product->category) == 'fruta' ? 'selected' : '' }}>Fruta</option>
                <option value="verdura" {{ old('category', $product->category) == 'verdura' ? 'selected' : '' }}>Verdura</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Imagem:</label>
            <input type="file" name="image" id="image" class="form-control-file">
            @if ($product->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
