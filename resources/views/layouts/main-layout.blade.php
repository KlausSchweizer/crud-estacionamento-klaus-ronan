<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estacione Aqui</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lumen/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-10/css/all.min.css" integrity="sha512-Pv1WJMqAtVgNNct5vhq+4cgkKinKpV1jCwSWD4am9CjwxsJSCkLWKcE/ZBqHnEE1mHs01c8B0GMvcn/pQ/yrog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}">Estacione aqui</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{request()->routeIs('home') ? 'active ': ''}}" href="{{route('home')}}">Home
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{request()->routeIs('vehicles*') ? 'active' : ''}}" href="{{route('vehicles')}}">Veículos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{request()->routeIs('parking*') ? 'active' : ''}}" href="{{route('parking')}}">Tickets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{request()->routeIs('users*') ? 'active' : ''}}" href="{{route('users')}}">Usuários</a>
                </li>
            </ul>
            <div>
                <form method="post" action="{{route('auth.logout')}}">
                    @csrf
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
@yield('breadcrumb')
@yield('content')
<footer class="bg-primary text-white text-center py-3 mt-auto">
    <div class="container">
        <p class="mb-0">&copy; {{ date('Y') }} Estacione Aqui. Todos os direitos reservados.</p>
    </div>
</footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
</html>
