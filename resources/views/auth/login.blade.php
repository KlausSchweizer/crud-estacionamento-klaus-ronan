@extends('layouts.auth-layout')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center h-75">
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
        <div class="card text-white bg-primary" style="max-width: 50rem; width: 50%">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form action="{{route('auth.login.authenticate')}}" method="post">
                    @csrf

                    <fieldset>
                        <div>
                            <label for="exampleInputEmail1" class="form-label">Digite seu e-mail</label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder="exemplo@email.com" value="{{old('email')}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label mt-4">Digite sua senha</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                                   placeholder="Senha"
                                   autocomplete="off">
                        </div>


                        <button type="submit" class="btn btn-secondary">Enviar</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
