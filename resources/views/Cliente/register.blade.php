@extends('layouts.main')

@section('title', 'Registrar')

@section('content')
<div class="content">
    <h2 class="agri-title">Criar Conta</h2>

    @if($errors->any())
    <div class="agri-alert agri-alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
    </div>
    @endif

    <form class="agri-form" method="POST" action="{{ route('cliente.register.post') }}">
        @csrf
        <div class="mb-3">
            <i class="fas fa-user input-icon"></i>
            <input 
                type="text" 
                name="name" 
                class="agri-form-control" 
                value="{{ old('name') }}" 
                placeholder="Nome" 
                required>
        </div>
        <div class="mb-3">
            <i class="fas fa-envelope input-icon"></i>
            <input 
                type="email" 
                name="email" 
                class="agri-form-control" 
                value="{{ old('email') }}" 
                placeholder="Email" 
                required>
        </div>
        <div class="mb-3">
            <i class="fas fa-lock input-icon"></i>
            <input 
                type="password" 
                name="password" 
                class="agri-form-control" 
                placeholder="Senha" 
                required>
        </div>
        <div class="mb-3">
            <i class="fas fa-lock input-icon"></i>
            <input 
                type="password" 
                name="password_confirmation" 
                class="agri-form-control" 
                placeholder="Confirme a Senha" 
                required>
        </div>
        <button type="submit" class="agri-btn agri-btn-success">
            Registrar
        </button>
        <br>
        <br>
        <div class="login-link">
            Já tem uma conta? <a href="{{ route('cliente.login') }}">Faça login aqui</a>
        </div>
    </form>
</div>
@endsection