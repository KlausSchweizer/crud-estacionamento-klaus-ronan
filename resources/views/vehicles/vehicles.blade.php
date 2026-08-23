@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Veículos</li>
    </ol>
@endsection

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between"><h2>Tabela de veículos</h2>
            <a class="text-decoration-none" href="{{route('vehicles.createPage')}}">
                <button type="button" class="btn btn-success"><i class="me-2 fas fa-plus"></i>Adicionar</button>
            </a>
        </div>
        <table class="table table-hover my-3">
            <thead>
            <tr class="table-primary">
                <th scope="col">ID</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Cor</th>
                <th scope="col">Placa</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vehicles as $vehicle)
                <tr>
                    <th scope="row">{{ $vehicle->id }}</th>
                    <td>{{ $vehicle->brand }}</td>
                    <td>{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->color }}</td>
                    <td>{{ $vehicle->plate }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{route('vehicles.edit', ['id' => \App\Services\EncrypterService::encrypt($vehicle->id)])}}"
                               class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center"
                               style="width: 35px; height: 35px;" title="Editar">
                                <i class="fas fa-pencil-alt text-white"></i>
                            </a>

                            <form method="post"
                                  action="{{route('vehicles.delete', ['id' => \App\Services\EncrypterService::encrypt($vehicle->id)])}}">
                                @csrf
                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 35px; height: 35px;" title="Excluir">
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
