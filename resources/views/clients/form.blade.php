@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('clients') }}">Clientes</a></li><li class="breadcrumb-item active">{{ isset($client) ? 'Editar' : 'Cadastrar' }}</li></ol>
@endsection

@section('content')
<div class="container">
    <h2>{{ isset($client) ? 'Editar cliente' : 'Cadastrar cliente' }}</h2>
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="post" action="{{ isset($client) ? route('clients.edit', ['id' => \App\Services\EncrypterService::encrypt($client->id)]) : route('clients.create') }}">
        @csrf
        <div class="mb-3"><label for="name" class="form-label">Nome</label><input class="form-control" id="name" name="name" required maxlength="255" value="{{ old('name', $client->name ?? '') }}"></div>
        <div class="mb-3"><label for="email" class="form-label">E-mail</label><input class="form-control" type="email" id="email" name="email" required maxlength="255" value="{{ old('email', $client->email ?? '') }}"></div>
        <button class="btn btn-primary" type="submit">Salvar cliente</button>
        <a class="btn btn-secondary" href="{{ route('clients') }}">Cancelar</a>
    </form>
</div>
@endsection
