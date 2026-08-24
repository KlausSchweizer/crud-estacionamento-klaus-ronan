@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('users')}}">Usuários</a></li>
        <li class="breadcrumb-item active">Cadastro de usuários</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <h2>Cadastro de usuário</h2>
        @if ($errors->any())
            <div class="alert alert-dismissible alert-danger" style="width: 50rem">
                <strong>Erro!</strong><br>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form
            method="post"
            action="{{isset($user) ? route('users.edit', ['id' => \App\Services\EncrypterService::encrypt($user->id)]) : route('users.create') }}">
            @csrf

            <div>
                <label for="inputName" class="form-label mt-2">Nome</label>
                <input type="text" class="form-control" id="inputName" name="username" placeholder="Digite o nome"
                       value="{{ old('username', $user->username ?? '') }}">
            </div>

            <div>
                <label for="inputMail" class="form-label mt-2">E-mail</label>
                <input type="email" class="form-control" id="inputMail" name="email" placeholder="Digite o e-mail"
                       value="{{ old('email', $user->email ?? '') }}">
            </div>

            @if(session()->get('user') !== null && isset($user) && session()->get('user')->id === $user->id)
                <div>
                    <label for="inputPassword" class="form-label mt-2">Placa</label>
                    <input type="password" class="form-control" id="inputPassword" name="password"
                           placeholder="Digite a senha">
                </div>
            @else
                <p class="mt-5">A senha padrão é "senha123"</p>
            @endif

            <div class="mt-4 mb-4">
                <button type="submit" class="btn btn-primary">Salvar usuário</button>
                <a href="{{ route('users') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
