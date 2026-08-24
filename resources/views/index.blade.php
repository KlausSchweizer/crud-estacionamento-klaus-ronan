@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Home</li>
    </ol>
@endsection
@section('content')
    <div class="d-flex justify-content-center">
        <h2>Dashboard</h2>
    </div>
        <div class="d-flex flex-wrap justify-content-center align-items-center">
            <a href="{{route('vehicles')}}" class="text-decoration-none">
                <div class="card text-white bg-primary mb-3 mx-2" style="max-width: 20rem;">
                    <div class="card-header"><i class="fas fa-car me-2" aria-hidden="true"></i>Veículos</div>
                    <div class="card-body">
                        <h4 class="card-title">Cadastro de veículos</h4>
                        <p class="card-text">Cadastre e gerencie os veículos que utilizam o estacionamento de forma rápida e organizada.</p>
                    </div>
                </div>
            </a>

            <a href="{{route('parking')}}" class="text-decoration-none">
                <div class="card text-black bg-secondary mb-3 mx-2" style="max-width: 20rem;">
                    <div class="card-header"><i class="fas fa-parking me-2" aria-hidden="true"></i>Tickets</div>
                    <div class="card-body">
                        <h4 class="card-title">Cadastro de tickets</h4>
                        <p class="card-text">Registre a entrada e a saída dos veículos e acompanhe os tickets do estacionamento.</p>
                    </div>
                </div>
            </a>

            <a href="{{route('users')}}" class="text-decoration-none">
                <div class="card text-black bg-info mb-3 mx-2" style="max-width: 20rem;">
                    <div class="card-header"><i class="fas fa-user me-2" aria-hidden="true"></i>Usuários</div>
                    <div class="card-body">
                        <h4 class="card-title">Cadastro de usuários</h4>
                        <p class="card-text">Cadastre e gerencie os usuários responsáveis pelo acesso e controle do sistema.</p>
                    </div>
                </div>
            </a>
    </div>
@endsection
