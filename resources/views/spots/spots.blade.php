@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Vagas</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h2>Vagas de estacionamento</h2>
            <form action="{{ route('spot.create') }}" method="POST" class="flex-shrink-0 m-0">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="me-2 fas fa-plus"></i>
                    Adicionar Nova Fileira
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="border rounded bg-white p-4 m-2">
            <div class="d-flex flex-column gap-1">

                @foreach($spotsByRow as $rowLetter => $spotsInRow)

                    <div class="d-flex align-items-center gap-2">

                        <span class="fw-bold text-secondary flex-shrink-0" style="width: 20px;">{{ $rowLetter }}</span>

                        <div class="d-flex align-items-center gap-2 overflow-x-auto py-1 px-1 w-100"
                             style="white-space: nowrap;">

                            @foreach($spotsInRow as $spot)

                                @php
                                    $isOcupada = $spot->parking && is_null($spot->parking->horario_saida);
                                    $carColor = '#ffffff';
                                    $vehicleId = null;
                                    $ticketId = null;

                                    if ($isOcupada && $spot->parking) {
                                        $ticketId = $spot->parking->ticket;
                                        if ($spot->parking->vehicle) {
                                            $vehicleId = $spot->parking->vehicle->id;
                                            $corVeiculo = strtolower(trim($spot->parking->vehicle->color ?? ''));

                                           $carColor = match($corVeiculo) {
                                               'preto' => '#1e293b',
                                                'branco' => '#ffffff',
                                                'prata' => '#cbd5e1',
                                                'azul' => '#0d6efd',
                                                'laranja' => '#f97316',
                                                'vermelho' => '#ef4444',
                                                default => '#e2e8f0',
                                            };
                                        }
                                    }
                                @endphp

                                <div
                                    class="d-flex flex-column align-items-center justify-content-center border rounded shadow-sm text-black fw-bold flex-shrink-0 position-relative overflow-hidden {{ $isOcupada ? 'bg-dark border-dark' : 'bg-secondary border-dark' }}"
                                    style="width: 50px; height: 100px; font-size: 20px; cursor: pointer; transition: transform 0.15s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">

                                    <form action="{{ route('spot.delete', $spot->id) }}" method="POST" class="position-absolute top-0 end-0 m-1" style="z-index: 4;" onsubmit="return confirm('Deseja realmente excluir esta vaga?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm p-0 d-flex align-items-center justify-content-center" style="width: 14px; height: 14px; font-size: 8px;" title="Excluir vaga">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                    @if($isOcupada && $vehicleId)
                                        <a href="{{ route('vehicles.edit', \App\Services\EncrypterService::encrypt($vehicleId)) }}" class="text-decoration-none text-white w-100 h-100 d-flex flex-column align-items-center justify-content-center position-absolute top-0 start-0" style="z-index: 2;" title="Editar veículo estacionado">
                                            @endif

                                            <span class="position-relative" style="line-height: 1; z-index: 3;">
                                        {{ $isOcupada ? '' : $spot->row }}{{ $isOcupada ? '' : $spot->index }}
                                    </span>

                                            @if($isOcupada)
                                                <x-car-icon
                                                    color="{{$carColor}}"
                                                    class="position-absolute"
                                                    style="width: 150px; height: 150px; transform: rotate(90deg); z-index: 1;"/>
                                            @endif

                                            @if($isOcupada && $vehicleId)
                                        </a>
                                    @endif

                                    @if($isOcupada && $ticketId)
                                        <form action="{{ route('parking.exit', \App\Services\EncrypterService::encrypt($ticketId)) }}" method="POST" class="position-absolute bottom-0 start-0 w-100 p-1" style="z-index: 4;" onsubmit="return confirm('Registrar saída deste veículo?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm w-100 py-0 d-flex align-items-center justify-content-center" style="height: 16px; font-size: 9px;" title="Registrar Saída">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>

                            @endforeach

                            <form action="{{ route('spot.create', [$rowLetter]) }}" method="POST"
                                  class="flex-shrink-0 m-0">
                                @csrf
                                <button type="submit"
                                        class="d-flex align-items-center justify-content-center border rounded shadow-sm text-white fw-bold bg-success border-success w-100 h-100 border-0"
                                        style="width: 50px; height: 100px; font-size: 20px; cursor: pointer; transition: transform 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>

                        </div>

                    </div>

                @endforeach

            </div>
        </div>
    </div>
@endsection
