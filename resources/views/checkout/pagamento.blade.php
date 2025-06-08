@extends('layouts.app') {{-- ou outro layout que você esteja usando --}}

@section('content')
<div class="container">
    <h1>Pagamento</h1>
    <p>Escolha sua forma de pagamento e finalize seu pedido.</p>

    <form method="POST" action="{{ route('finalizar.pagamento') }}">
        @csrf

        <div class="mb-3">
            <label for="forma_pagamento" class="form-label">Forma de pagamento:</label>
            <select name="forma_pagamento" id="forma_pagamento" class="form-control" required>
                <option value="">Selecione</option>
                <option value="pix">PIX</option>
                <option value="credito">Cartão de Crédito</option>
                <option value="debito">Cartão de Débito</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Finalizar Pagamento</button>
    </form>
</div>
@endsection
