 @extends('layouts.app')
@section('title', 'Lista de Pedidos')

@section('content')
<div class="agri-container">
    <h1 class="agri-title">Lista de Pedidos</h1>

    <div class="agri-orders-list">
        @foreach ($pedidos as $pedido)
            @php
                // Decodifica produtos e endereço se necessário
                $produtos = $pedido->produtos;
                if (is_string($produtos)) {
                    $produtos = json_decode($produtos, true) ?? [];
                }
                $endereco = $pedido->endereco;
                if (is_string($endereco)) {
                    $endereco = json_decode($endereco, true);
                }
            @endphp
            <div class="agri-order-card">
                <div class="agri-order-header">
                    <h3 class="agri-order-client">{{ $pedido->nome }}</h3>
                    <span class="agri-order-status">{{ $pedido->status ?? 'Novo' }}</span>
                </div>

                <div class="agri-order-details">
                    <div class="agri-order-section">
                        <h4 class="agri-order-subtitle" style="display: flex; align-items: center; gap: 6px;">
                            @if($pedido->tipo_entrega === 'entrega')
                                <i class="fas fa-truck"></i> Entrega
                            @else
                                <i class="fas fa-store"></i> Retirada
                            @endif
                        </h4>
                        <p>{{ $pedido->tipo_entrega }}</p>
                        @if($pedido->tipo_entrega === 'entrega' && is_array($endereco))
                        <p>
                            {{ $endereco['rua'] ?? '' }}, {{ $endereco['numero'] ?? '' }}<br>
                            {{ $endereco['bairro'] ?? '' }} - {{ $endereco['cep'] ?? '' }}
                        </p>
                        @elseif($pedido->tipo_entrega === 'entrega')
                            <p>{{ $pedido->endereco }}</p>
                        @else
                            <p>Retirada no balcão</p>
                        @endif
                    </div>

                    <div class="agri-order-section">
                        <h4 class="agri-order-subtitle" style="display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-credit-card"></i> Pagamento
                        </h4>
                        <p>{{ $pedido->pagamento }}</p>
                    </div>
                </div>

                <div class="agri-order-products">
                    <h4 class="agri-order-subtitle" style="display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-shopping-basket"></i> Produtos
                    </h4>
                    <ul class="agri-product-list">
                        @php $total = 0; @endphp
                        @foreach ($produtos as $produto)
                            <li class="agri-product-item">
                                <span class="agri-product-name">{{ $produto['nome'] ?? '' }}</span>
                                <span class="agri-product-quantity">{{ $produto['quantidade'] ?? '' }}x</span>
                                <span class="agri-product-price">R$ {{ number_format($produto['preco'] ?? 0, 2, ',', '.') }}</span>
                                @php
                                    $total += ($produto['preco'] ?? 0) * ($produto['quantidade'] ?? 1);
                                @endphp
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="agri-order-footer">
                    <div class="agri-order-total">
                        <strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}
                    </div>

                    @php
                        $mensagem = "Novo Pedido!\n";
                        $mensagem .= "Cliente: {$pedido->nome}\n";
                        $mensagem .= "Entrega: {$pedido->tipo_entrega} ";
                        if(is_array($endereco)) {
                            $mensagem .= ($endereco['rua'] ?? '') . ', ' . ($endereco['numero'] ?? '') . ' ' . ($endereco['bairro'] ?? '') . ' ' . ($endereco['cep'] ?? '');
                        } else {
                            $mensagem .= $pedido->endereco;
                        }
                        $mensagem .= "\nPagamento: {$pedido->pagamento}\n";
                        $mensagem .= "Produtos:\n";
                        foreach ($produtos as $produto) {
                            $mensagem .= "- " . ($produto['nome'] ?? '') . " (Qtd: " . ($produto['quantidade'] ?? '') . ", Preço: R$ " . number_format($produto['preco'] ?? 0, 2, ',', '.') . ")\n";
                        }
                        $mensagem .= "Total: R$ " . number_format($total, 2, ',', '.');
                        $whatsappLink = 'https://web.whatsapp.com/send?phone=5542999640097&text=' . urlencode($mensagem);
                    @endphp

                    <a href="{{ $whatsappLink }}" target="_blank" class="agri-btn agri-btn-whatsapp">
                        <i class="fab fa-whatsapp"></i> Enviar para WhatsApp
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection