@extends('layouts.main')
@section('title', 'Login Admin')

@section('content')
<div class="agri-container">
    <h2 class="agri-title">Login Administrador</h2>
    
    @if($errors->any())
        <div class="agri-alert agri-alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    
    <form class="agri-form" method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="mb-3">
            <label>Email:</label>
            <input class="agri-form-control" type="email" name="email" required autofocus>
        </div>
        <div class="mb-3">
            <label>Senha:</label>
            <input class="agri-form-control" type="password" name="password" required>
        </div>
        <button class="agri-btn agri-btn-success" type="submit">Entrar</button>
      
    </form>
</div>
@endsection