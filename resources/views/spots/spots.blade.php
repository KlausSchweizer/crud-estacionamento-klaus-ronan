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
                    Adicionar
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

        <div class="card shadow-sm p-4">
            <div class="d-flex flex-column gap-3">

                @foreach($spotsByRow as $rowLetter => $spotsInRow)

                    <div class="d-flex align-items-center gap-2">

                        <span class="fw-bold text-secondary flex-shrink-0" style="width: 20px;">{{ $rowLetter }}</span>

                        <div class="d-flex align-items-center gap-2 overflow-x-auto pb-2 w-100"
                             style="white-space: nowrap;">

                            @foreach($spotsInRow as $spot)

                                @php
                                    $isOcupada = $spot->parking && is_null($spot->parking->horario_saida);
                                    $carColor = '#ffffff';

                                    if ($isOcupada && $spot->parking->vehicle) {
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
                                @endphp

                                <div
                                    class="d-flex flex-column align-items-center justify-content-center border rounded shadow-sm text-white fw-bold flex-shrink-0 position-relative overflow-hidden {{ $isOcupada ? 'bg-dark border-dark' : 'bg-warning border-warning' }}"
                                    style="width: 50px; height: 100px; font-size: 20px; cursor: pointer; transition: transform 0.15s ease;"
                                    onmouseover="this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.transform='scale(1)'">

                                    <form action="{{ route('spot.delete', $spot->id) }}" method="POST" class="position-absolute top-0 end-0 m-1" onsubmit="return confirm('Deseja realmente excluir esta vaga?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm p-0 d-flex align-items-center justify-content-center" style="width: 12px; height: 12px; font-size: 8px; z-index: 3;" title="Excluir vaga">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                    <span class="position-relative"
                                          style=" line-height: 1; z-index: 2;">{{$isOcupada ? '' : $spot->row }}{{$isOcupada ? '' : $spot->index }}</span>

                                    @if($isOcupada)
                                        <x-car-icon
                                            color="{{$carColor}}"
                                            class="position-absolute"
                                            style="width: 200px; height: 200px; transform: rotate(90deg); z-index: 1;"/>
                                    @endif

                                </div>

                            @endforeach

                            <form action="{{ route('spot.create', [$rowLetter]) }}" method="POST"
                                  class="flex-shrink-0 m-0">
                                @csrf
                                <button type="submit"
                                        class="d-flex align-items-center justify-content-center border rounded shadow-sm text-white fw-bold bg-success border-success w-100 h-100 border-0"
                                        style="width: 50px; height: 100px; font-size: 20px; cursor: pointer; transition: transform 0.15s ease;"
                                        onmouseover="this.style.transform='scale(1.1)'"
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
