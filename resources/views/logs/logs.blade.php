@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Usuários</li>
    </ol>
@endsection

@php
    $eventos = [
        'created'     => 'Cadastro',
        'updated'     => 'Edição',
        'deleted'     => 'Exclusão',
        'restored'    => 'Restauração',
        'visualized'  => 'Visualização',
        'login'       => 'Login',
        'logout'      => 'Logout',
        'retirada'    => 'Retirada',
    ];
@endphp


@section('content')
    <div class="container">

        <div class="d-flex justify-content-between"><h2>Tabela de usuários</h2>
            <a class="text-decoration-none" href="{{route('users.createPage')}}">
                <button type="button" class="btn btn-success"><i class="me-2 fas fa-plus"></i>Adicionar</button>
            </a>
        </div>
        @if ($logs->isEmpty())

            <div class="text-center text-body-secondary mt-5">
                <i class="fa-solid fa-clipboard-list fa-3x mb-3"></i>
                <p>Nenhum log encontrado para este filtro.</p>
            </div>

        @else

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Evento</th>
                        <th>Descrição</th>
                        <th>Afetado</th>
                        <th>Realizado por</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @foreach ($logs as $log)
                        <tr>
                            <td class="text-nowrap num">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $eventos[$log->event] ?? $log->event }}</td>
                            <td>
                                {{ $log->description }}
                                </td>
                            <td>
                                <span class="selo">{{ $log->subject?->username }}</span>
                            </td>
                            <td>{{ $log->causer?->username ?? '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

@endsection

