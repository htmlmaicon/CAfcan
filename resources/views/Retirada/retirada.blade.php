@extends('layouts.app')
@section('title', 'Endereço de Entrega')

@section('content')
<div class="agri-container">
    <form method="POST" action="{{ route('salvar.endereco.entrega') }}" class="agri-form">
        @csrf

        <h4 class="agri-title">Escolha o método de entrega</h4>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif

        <div class="agri-delivery-option">
            <input type="radio" name="tipo_entrega" value="retirada" id="retirada"
                {{ old('tipo_entrega', 'retirada') === 'retirada' ? 'checked' : '' }} class="agri-radio">
            <label for="retirada" class="agri-radio-label">Retirar no endereço: Manoel Lopes de Oliveira, 2870 - Centro (sem taxa)</label>
        </div>

        <div class="agri-delivery-option">
            <input type="radio" name="tipo_entrega" value="entrega" id="entrega"
                {{ old('tipo_entrega') === 'entrega' ? 'checked' : '' }} class="agri-radio">
            <label for="entrega" class="agri-radio-label">Entregar no meu endereço (R$5,00 taxa)</label>
        </div>

        <div id="endereco-fields" class="agri-address-fields">
            <div class="agri-form-group">
                <label class="agri-form-label">Rua:</label>
                <input type="text" name="rua" class="agri-form-control" value="{{ old('rua', $cliente->endereco->rua ?? '') }}">
            </div>
            
            <div class="agri-form-group">
                <label class="agri-form-label">Número:</label>
                <input type="text" name="numero" class="agri-form-control" value="{{ old('numero', $cliente->endereco->numero ?? '') }}">
            </div>
            
            <div class="agri-form-group">
                <label class="agri-form-label">Bairro:</label>
                <input type="text" name="bairro" class="agri-form-control" value="{{ old('bairro', $cliente->endereco->bairro ?? '') }}">
            </div>
            
            <div class="agri-form-group">
                <label class="agri-form-label">CEP:</label>
                <input type="text" name="cep" class="agri-form-control" value="{{ old('cep', $cliente->endereco->cep ?? '') }}">
            </div>
        </div>

        <button type="submit" class="agri-btn agri-btn-success agri-btn-block">Continuar</button>
    </form>
</div>

<script>
    function toggleEnderecoFields() {
        const show = document.querySelector('input[name="tipo_entrega"]:checked').value === 'entrega';
        document.getElementById('endereco-fields').style.display = show ? 'block' : 'none';
    }
    document.querySelectorAll('input[name="tipo_entrega"]').forEach(el => {
        el.addEventListener('change', toggleEnderecoFields);
    });
    window.onload = toggleEnderecoFields;
</script>
@endsection