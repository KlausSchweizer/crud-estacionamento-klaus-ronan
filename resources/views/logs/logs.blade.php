@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Interações</li>
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

        <div class="d-flex justify-content-between">
            <h2>Interações e Logs</h2>
            <a class="text-decoration-none" href="{{ route('logs.pdf') }}">
                <button type="button" class="btn btn-secondary"><i class="me-2 fas fa-download"></i>Baixar PDF</button>
            </a></div>
        @if ($logs->isEmpty())

            <div class="text-center text-body-secondary mt-5">
                <i class="fa-solid fa-clipboard-list fa-3x mb-3"></i>
                <p>Nenhum log encontrado para este filtro.</p>
            </div>

        @else

            <div class="table-responsive">
                <table class="table table-hover my-3">
                    <thead>
                    <tr class="table-primary">
                        <th scope="col">Data</th>
                        <th scope="col">Evento</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Realizado por</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td class="text-nowrap num">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td><b>{{ $eventos[$log->event] ?? $log->event }}</b></td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->causer?->name ?? $log->causer?->username ?? '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

@endsection

