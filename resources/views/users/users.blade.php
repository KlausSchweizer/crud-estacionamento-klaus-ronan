@extends('layouts.main-layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Usuários</li>
    </ol>
@endsection

@section('content')
    <div class="container">

        <div class="modal fade" tabindex="-1" id="deleteModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Atenção!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir este usuário?</p>
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Excluir</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between"><h2>Tabela de usuários</h2>
            <a class="text-decoration-none" href="{{route('users.createPage')}}">
                <button type="button" class="btn btn-success"><i class="me-2 fas fa-plus"></i>Adicionar</button>
            </a>
        </div>
        <table class="table table-hover my-3">
            <thead>
            <tr class="table-primary">
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Último login</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->last_login ? date('d/m/Y H:i:s', strtotime($user->last_login)) : '' }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{route('users.edit', ['id' => \App\Services\EncrypterService::encrypt($user->id)])}}"
                               class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center"
                               style="width: 35px; height: 35px;" title="Editar">
                                <i class="fas fa-pencil-alt text-white"></i>
                            </a>

                            <button
                                type="button"

                                class="btn btn-danger remove-button btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px;"
                                data-url="{{ route('users.delete', ['id' => \App\Services\EncrypterService::encrypt($user->id)]) }}"
                                title="Excluir"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <script>
        const form = document.getElementById('deleteForm');
        document.querySelectorAll('.remove-button').forEach(b => {
            b.addEventListener('click', () => {
                const url = b.getAttribute('data-url');
                form.setAttribute('action', url);
            });
        });
    </script>
@endsection

