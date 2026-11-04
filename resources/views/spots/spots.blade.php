@php use App\Services\EncrypterService; @endphp
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

        <div class="card shadow-sm p-4">
            <div class="d-flex flex-column gap-3">

                @foreach($spotsByRow as $rowLetter => $spotsInRow)

                    <div class="d-flex align-items-center gap-2">

                        <span class="fw-bold text-secondary flex-shrink-0" style="width: 20px;">{{ $rowLetter }}</span>

                        <div class="d-flex align-items-center gap-2 overflow-x-auto pb-2 w-100" style="white-space: nowrap;">

                            @foreach($spotsInRow as $spot)

                                @php
                                    $isOcupada = $spot->parking && is_null($spot->parking->horario_saida);
                                @endphp

                                <div
                                    class="d-flex align-items-center justify-content-center border rounded shadow-sm text-white fw-bold flex-shrink-0 {{ $isOcupada ? 'bg-danger border-danger' : 'bg-warning border-warning' }}"
                                    style="width: 50px; height: 100px; font-size: 20px; cursor: pointer; transition: transform 0.15s ease;"
                                    onmouseover="this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    {{ $spot->row }}{{ $spot->index }}
                                </div>

                            @endforeach

                            <div
                                class="d-flex align-items-center justify-content-center border rounded shadow-sm text-white fw-bold bg-success border-success flex-shrink-0"
                                style="width: 50px; height: 100px; font-size: 20px; cursor: pointer; transition: transform 0.15s ease;"
                                onmouseover="this.style.transform='scale(1.1)'"
                                onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-plus"></i>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>
        </div>
    </div>
@endsection
