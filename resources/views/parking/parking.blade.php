@php use App\Services\EncrypterService; @endphp
@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Estacionamentos</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>Tickets de estacionamento</h2>
            <a class="text-decoration-none" href="{{ route('parking.createPage') }}">
                <button type="button" class="btn btn-success">
                    <i class="me-2 fas fa-plus"></i>
                    Adicionar
                </button>
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <table class="table table-hover my-3">
            <thead>
                <tr class="table-primary">
                    <th>Ticket</th>
                    <th>Veículo</th>
                    <th>Placa</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach($parkings as $parking)
                    <tr>
                        <th scope="row">{{ $parking->ticket }}</th>

                        <td>
                            {{ $parking->vehicle?->brand }}
                            {{ $parking->vehicle?->model }}
                        </td>

                        <td>{{ $parking->vehicle?->plate }}</td>
                        <td>{{ $parking->horario_entrada }}</td>

                        <td>
                            @if($parking->horario_saida)
                                {{ $parking->horario_saida }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            @if($parking->preco !== null)
                                R$ {{ number_format($parking->preco, 2, ',', '.') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            @if($parking->horario_saida)
                                <span class="badge bg-secondary">Finalizado</span>
                            @else
                                <span class="badge bg-success">Estacionado</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if(!$parking->horario_saida)
                                    <form method="post"
                                        action="{{ route('parking.exit', ['ticket' => \App\Services\EncrypterService::encrypt($parking->ticket)]) }}">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 35px; height: 35px;"
                                            title="Registrar saída">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('parking.editPage', ['ticket' => \App\Services\EncrypterService::encrypt($parking->ticket)]) }}"
                                    class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 35px; height: 35px;"
                                    title="Editar">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </a>

                                <form method="post"
                                    action="{{ route('parking.delete', ['ticket' => \App\Services\EncrypterService::encrypt($parking->ticket)]) }}">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;"
                                        title="Excluir">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
