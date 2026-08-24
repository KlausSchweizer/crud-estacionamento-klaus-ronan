@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Home</a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('parking') }}">Estacionamentos</a>
        </li>

        <li class="breadcrumb-item active">
            {{ isset($parking) ? 'Editar estacionamento' : 'Cadastro de estacionamento' }}
        </li>
    </ol>
@endsection

@section('content')
    <div class="container">

        <h2>
            {{ isset($parking) ? 'Editar estacionamento' : 'Cadastro de estacionamento' }}
        </h2>

        @if ($errors->any())
            <div class="alert alert-dismissible alert-danger" style="width: 50rem">
                <strong>Erro!</strong><br>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="post"
            action="{{ isset($parking)
                ? route('parking.edit', [
                    'ticket' => \App\Services\EncrypterService::encrypt($parking->ticket)
                ])
                : route('parking.create')
            }}"
        >
            @csrf

            <div>
                <label for="vehicles_id" class="form-label mt-2">
                    Veículo
                </label>

                <select
                    class="form-select"
                    id="vehicles_id"
                    name="vehicles_id"
                    required
                >
                    <option value="" disabled
                        {{ old('vehicles_id', $parking->vehicles_id ?? '') == '' ? 'selected' : '' }}>
                        Selecione o veículo
                    </option>

                    @foreach($vehicles as $vehicle)
                        <option
                            value="{{ $vehicle->id }}"
                            {{ old('vehicles_id', $parking->vehicles_id ?? '') == $vehicle->id ? 'selected' : '' }}
                        >
                            {{ $vehicle->brand }}
                            {{ $vehicle->model }}
                            - {{ $vehicle->plate }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(isset($parking))
                <div>
                    <label for="ticket" class="form-label mt-2">
                        Ticket
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="ticket"
                        value="{{ $parking->ticket }}"
                        readonly
                    >
                </div>
            @endif

            <div>
                <label for="horario_entrada" class="form-label mt-2">
                    Horário de entrada
                </label>

                <input
                    type="time"
                    class="form-control"
                    id="horario_entrada"
                    name="horario_entrada"
                    value="{{ old('horario_entrada', $parking->horario_entrada ?? '') }}"
                >
            </div>

            <div>
                <label for="horario_saida" class="form-label mt-2">
                    Horário de saída
                </label>

                <input
                    type="time"
                    class="form-control"
                    id="horario_saida"
                    name="horario_saida"
                    value="{{ old('horario_saida', $parking->horario_saida ?? '') }}"
                >
            </div>

            <div>
                <label for="preco" class="form-label mt-2">
                    Preço
                </label>

                <div class="input-group">
                    <span class="input-group-text">R$</span>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        id="preco"
                        name="preco"
                        placeholder="Digite o preço"
                        value="{{ old('preco', $parking->preco ?? '') }}"
                    >
                </div>
            </div>

            <div class="mt-4 mb-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($parking) ? 'Salvar alterações' : 'Salvar estacionamento' }}
                </button>

                <a href="{{ route('parking') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
@endsection