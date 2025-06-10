<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema delivery')</title>
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <!-- Adicione o Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside id="sidebar" class="sidebar expanded">
            <button id="toggleBtn" class="sidebar-toggle">
                <span class="sidebar-icon">&#9776;</span>
                <span class="toggle-text">Menu</span>
            </button>
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> <span>Home</span></a></li>
                    @guest('cliente')
                        <li>
                            <a href="{{ route('admin.login') }}">
                                <i class="fas fa-key"></i> <span>LoginADM</span>
                            </a>
                        </li>
                    @endguest
                    @auth('cliente')
                    <li><a href="{{ route('pedidos.index') }}"><i class="fas fa-clipboard-list"></i> <span>Pedidos</span></a></li>
                    @endauth
                    
                </ul>
            </nav>
        </aside>

        <div class="main">
            <header class="header">
                <div class="header-logo">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo AgroSystem" class="logo">
                </div>
                <div class="header-actions">
                    <!-- Carrinho com contador -->
                    <a href="{{ route('cart.index') }}" class="cart-link">
                        <i class="fas fa-shopping-cart"></i>
                         
                    </a>
                    
                    <!-- Links de autenticação do cliente -->
                    <div class="auth-links">
                        @guest('cliente')
                            <a href="{{ route('cliente.register') }}" class="auth-link"><i class="fas fa-user-plus"></i> Cadastrar</a>
                            <a href="{{ route('cliente.login') }}" class="auth-link"><i class="fas fa-sign-in-alt"></i> Entrar</a>
                        @endguest
                        
                        @auth('cliente')
                            <form method="POST" action="{{ route('cliente.logout') }}">
                                @csrf
                                <button type="submit" class="auth-link logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleBtn');
            const sidebar = document.getElementById('sidebar');
            
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                sidebar.classList.toggle('expanded');
            });
        });
    </script>
</body>
</html>