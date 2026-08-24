@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('vehicles')}}">Veículos</a></li>
        <li class="breadcrumb-item active">Cadastro de Veículos</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <h2>Cadastro de veículo</h2>
        @if ($errors->any())
            <div class="alert alert-dismissible alert-danger" style="width: 50rem">
                <strong>Erro!</strong><br>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form
            method="post"
            action="{{isset($vehicle) ? route('vehicles.edit', ['id' => \App\Services\EncrypterService::encrypt($vehicle->id)]) : route('vehicles.create') }}">
            @csrf

            <div>
                <label for="inputBrand" class="form-label mt-2">Marca</label>
                <input type="text" class="form-control" id="inputBrand" name="brand" placeholder="Digite a marca"
                       value="{{ old('brand', $vehicle->brand ?? '') }}">
            </div>

            <div>
                <label for="inputModel" class="form-label mt-2">Modelo</label>
                <input type="text" class="form-control" id="inputModel" name="model" placeholder="Digite o modelo"
                       value="{{ old('model', $vehicle->model ?? '') }}">
            </div>

            <div class="mb-0">
                <label for="color" class="form-label mt-2">Cor do veículo</label>
                <select class="form-select" id="color" name="color" required>
                    <option value="" disabled {{ isset($vehicle) ? 'selected' : '' }}>Selecione a cor</option>
                    <option value="Preto" {{ (old('color', $vehicle->color ?? '') == 'Preto') ? 'selected' : '' }}>Preto</option>
                    <option value="Branco" {{ (old('color', $vehicle->color ?? '') == 'Branco') ? 'selected' : '' }}>Branco</option>
                    <option value="Prata" {{ (old('color', $vehicle->color ?? '') == 'Prata') ? 'selected' : '' }}>Prata</option>
                    <option value="Vermelho" {{ (old('color', $vehicle->color ?? '') == 'Vermelho') ? 'selected' : '' }}>Vermelho</option>
                    <option value="Azul" {{ (old('color', $vehicle->color ?? '') == 'Azul') ? 'selected' : '' }}>Azul</option>
                    <option value="Laranja" {{ (old('color', $vehicle->color ?? '') == 'Laranja') ? 'selected' : '' }}>Laranja</option>
                </select>
            </div>

            <div>
                <label for="inputPlate" class="form-label mt-2">Placa</label>
                <input type="text" size="7" class="form-control" id="inputPlate" name="plate" placeholder="Digite a placa"
                       value="{{ old('plate', $vehicle->plate ?? '') }}">
            </div>

            <div class="mt-4 mb-4">
                <button type="submit" class="btn btn-primary">Salvar Veículo</button>
                <a href="{{ route('vehicles') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
