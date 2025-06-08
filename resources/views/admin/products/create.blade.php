@extends('layouts.main')

@section('title', 'Cadastrar Produto')
@section('header-title', 'Novo Produto ')

@section('content')
<div class="agri-container">
    
    @if($errors->any())
        <div class="agri-alert agri-alert-danger">
            <ul class="agri-error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="agri-form" method="POST" action="{{ route('products.index') }}" enctype="multipart/form-data">
        @csrf
        <div class="agri-form-grid">
            <div class="agri-form-group">
                <label>Nome do Produto</label>
                <input type="text" class="agri-form-control" name="name" required maxlength="100" placeholder="Ex: Maçã Fuji">
            </div>

            <div class="agri-form-group">
                <label>Preço (R$) <small>(use vírgula para centavos)</small></label>
                <input type="text" class="agri-form-control" name="price" required maxlength="10" pattern="^\d{1,6},\d{2}$" title="Exemplo: 12,90" placeholder="Ex: 12,90">
            </div>
        </div>

        <div class="agri-form-group">
            <label>Imagem do Produto</label>
            <input type="file" class="agri-form-control" name="image" accept="image/jpeg,image/png" required>
            <small class="agri-form-text">Formatos aceitos: JPEG, PNG (Max 2MB)</small>
        </div>

        <div class="agri-form-group">
            <label>Descrição Detalhada</label>
            <textarea class="agri-form-control" name="description" rows="4" required maxlength="500"
                placeholder="Descreva características do produto"></textarea>
        </div>
        <div class="agri-form-group">
            <label>Quantidade em Estoque (KG)</label>
            <input type="number" class="agri-form-control" name="quantity" min="0" step="0.01" required max="99999" placeholder="Ex: 100.00">
            <small class="agri-form-text">Informe a quantidade em KG. Use ponto para decimais (Ex: 1.50)</small>
        </div>
        <br>
        
        <div class="agri-form-group">
            <label>Categoria</label>
            <select class="agri-form-control" name="category" required>
                <option value="">Selecione uma categoria</option>
                <option value="congelado">🥶 Congelado</option>
                <option value="panificado">🍞 Panificado</option>
                <option value="fruta">🍎 Fruta</option>
                <option value="verdura">🥦 Verdura</option>
            </select>
        </div>
        <br>

        <div class="agri-btn-group">
            <button type="submit" class="agri-btn agri-btn-success">
                Cadastrar Produto
            </button>
            <a href="{{ route('products.index') }}" class="agri-btn agri-btn-secondary">
                📋 Ver Todos os Produtos
            </a>
            <a href="{{ route('home') }}"  class="agri-btn agri-btn-secondary">
              🏠Voltar para Menu
            </a>
        </div>
    </form>
</div>

<script>
document.querySelector('input[name="image"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const allowedTypes = ['image/jpeg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Apenas arquivos JPEG ou PNG são permitidos.');
            e.target.value = '';
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('O tamanho máximo da imagem é 2MB.');
            e.target.value = '';
        }
    }
});
</script>
@endsection