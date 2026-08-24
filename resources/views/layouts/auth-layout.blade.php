<!DOCTYPE html>
<html lang="pt-br" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lumen/bootstrap.min.css">
</head>
<body class="h-100">
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid justify-content-center">
        <a class="navbar-brand" href="{{route('home')}}">Estacione Aqui</a>
    </div>
</nav>
@yield('content')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
</html>
