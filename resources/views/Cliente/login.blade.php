@extends('layouts.main')

@section('title', 'Login do Cliente')

@section('content')

<h2 class="agri-title">Login do Cliente</h2>

@if(session('success'))
    <div class="alert alert-success text-center">
        <p>{{ session('success') }}</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
@endif

@if($errors->any())
    <div class="alert alert-danger text-center">
        <ul style="list-style:none;padding:0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('cliente.login') }}";
        }, 3000);
    </script>
@endif

<form method="POST" action="{{ route('cliente.login') }}" class="agri-form">
    @csrf
    <div class="mb-3">
        <i class="fas fa-envelope input-icon"></i>
        <input type="email" name="email" class="agri-form-control" placeholder="Email" required>
    </div>
    <div class="mb-3">
        <i class="fas fa-lock input-icon"></i>
        <input type="password" name="password" class="agri-form-control" placeholder="Senha" required>
    </div>
    <button type="submit" class="agri-btn agri-btn-success">Entrar</button>
    <br>
    <br>
    <div class="mt-3 text-center">
        <a href="{{ route('cliente.register') }}" class="agri-link">Não tem cadastro? Clique aqui para se registrar</a>
    </div>
</form>

@endsection