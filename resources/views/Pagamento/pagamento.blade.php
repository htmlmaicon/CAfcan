
@extends('layouts.app')
@section('title', 'Pagamento')

@section('content')
<div class="agri-container">
    <div class="agri-payment-container">
        <h1 class="agri-title">Pagamento</h1>
        <p class="agri-subtitle">Escolha sua forma de pagamento e finalize seu pedido.</p>

        {{-- Exibe mensagem de autenticação, se houver --}}
        @if($errors->has('auth'))
            <div class="alert alert-danger" style="margin-bottom: 15px;">
                {{ $errors->first('auth') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pagamento') }}" class="agri-form">
            @csrf

            <div class="agri-form-group">
                <label for="forma_pagamento" class="agri-form-label">Forma de pagamento:</label>
                <select name="forma_pagamento" id="forma_pagamento" class="agri-form-control" required>
                    <option value="">Selecione</option>
                    <option value="pix">PIX</option>
                    <option value="credito">Cartão de Crédito</option>
                    <option value="debito">Cartão de Débito</option>
                </select>
            </div>

            <div class="agri-payment-methods">
                <div class="agri-payment-option" data-payment="pix">
                    <div class="agri-payment-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <span>PIX</span>
                </div>
                
                <div class="agri-payment-option" data-payment="credito">
                    <div class="agri-payment-icon">
                        <i class="far fa-credit-card"></i>
                    </div>
                    <span>Crédito</span>
                </div>
                
                <div class="agri-payment-option" data-payment="debito">
                    <div class="agri-payment-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <span>Débito</span>
                </div>
            </div>

            <button type="submit" class="agri-btn agri-btn-success agri-btn-block">
                <i class="fas fa-lock"></i> Finalizar Pagamento
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecionar opção de pagamento ao clicar nos ícones
        const paymentOptions = document.querySelectorAll('.agri-payment-option');
        const paymentSelect = document.getElementById('forma_pagamento');
        
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                const paymentValue = this.getAttribute('data-payment');
                paymentSelect.value = paymentValue;
                
                // Remover classe ativa de todas as opções
                paymentOptions.forEach(opt => {
                    opt.classList.remove('active');
                });
                
                // Adicionar classe ativa à opção selecionada
                this.classList.add('active');
            });
        });
        
        // Atualizar visualização quando o select mudar
        paymentSelect.addEventListener('change', function() {
            paymentOptions.forEach(opt => {
                opt.classList.remove('active');
                if(opt.getAttribute('data-payment') === this.value) {
                    opt.classList.add('active');
                }
            });
        });
    });
</script>
@endsection