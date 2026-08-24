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
            {{ isset($parking) ? 'Editar Ticket' : 'Novo Ticket' }}
        </li>
    </ol>
@endsection

@section('content')

    <div class="container">

        <h2>
            {{ isset($parking) ? 'Editar ticket' : 'Cadastrar ticket' }}
        </h2>

        @if ($errors->any())
            <div class="alert alert-dismissible alert-danger" style="width: 50rem">

                <strong>Erro!</strong><br>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <form method="post" action="{{ isset($parking)
        ? route('parking.edit', [
            'ticket' => \App\Services\EncrypterService::encrypt($parking->ticket)
        ])
        : route('parking.create')
                }}">

            @csrf

            <div>
                <label for="vehicles_id" class="form-label mt-2">
                    Veículo
                </label>

                <select class="form-select" id="vehicles_id" name="vehicles_id" required>

                    <option value="" disabled {{ old('vehicles_id', $parking->vehicles_id ?? '') == '' ? 'selected' : '' }}>
                        Selecione o veículo
                    </option>

                    @foreach($vehicles as $vehicle)

                        <option value="{{ $vehicle->id }}" {{ old('vehicles_id', $parking->vehicles_id ?? '') == $vehicle->id ? 'selected' : '' }}>

                            {{ $vehicle->brand }}
                            {{ $vehicle->model }}
                            - {{ $vehicle->plate }}

                        </option>

                    @endforeach

                </select>
            </div>


            @if(isset($parking))

                <div>
                    <label class="form-label mt-2">
                        Ticket
                    </label>

                    <input type="text" class="form-control" value="{{ $parking->ticket }}" readonly>
                </div>

            @endif


            <div>

                <label for="horario_entrada" class="form-label mt-2">

                    Horário de entrada

                </label>

                <input type="time" class="form-control" id="horario_entrada" name="horario_entrada"
                    value="{{ old('horario_entrada', $parking->horario_entrada ?? date('H:i')) }}" required>

            </div>


            <div class="mt-4 mb-4">

                <button type="submit" class="btn btn-primary">

                    Salvar Ticket

                </button>

                <a href="{{ route('parking') }}" class="btn btn-secondary">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

@endsection