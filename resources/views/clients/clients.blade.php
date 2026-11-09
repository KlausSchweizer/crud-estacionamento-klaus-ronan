@extends('layouts.main-layout')

@section('breadcrumb')
<ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Clientes</li></ol>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center"><h2>Tabela de clientes</h2><a href="{{ route('clients.createPage') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Adicionar</a></div>
    @if(session('success'))<div class="alert alert-success mt-3">{{ session('success') }}</div>@endif
    <table class="table table-hover my-3"><thead><tr class="table-primary"><th>ID</th><th>Nome</th><th>E-mail</th><th>Veículos</th><th>Ações</th></tr></thead><tbody>
    @forelse($clients as $client)
        <tr><td>{{ $client->id }}</td><td>{{ $client->name }}</td><td>{{ $client->email }}</td><td>{{ $client->vehicles_count }}</td><td>
            <div class="d-flex gap-2"><a class="btn btn-warning btn-sm" href="{{ route('clients.edit', ['id' => \App\Services\EncrypterService::encrypt($client->id)]) }}">Editar</a>
            <form method="post" action="{{ route('clients.delete', ['id' => \App\Services\EncrypterService::encrypt($client->id)]) }}" onsubmit="return confirm('Excluir este cliente?')">@csrf<button class="btn btn-danger btn-sm" type="submit">Excluir</button></form></div>
        </td></tr>
    @empty<tr><td colspan="5">Nenhum cliente cadastrado.</td></tr>@endforelse
    </tbody></table>
</div>
@endsection
