<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Veículos — Estacione Aqui</title>

    <style>
        @page { size: A4 portrait; margin: 1.5cm 1.5cm 1.8cm 1.5cm; }

        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; margin-bottom: 20px; background-color: #ffffff; }

        .cabecalho { border-bottom: 2px solid #158cba; padding-bottom: 8px; margin-bottom: 20px; }
        h1 { font-size: 20px; margin: 0; color: #158cba; }

        table.itens { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.itens th { background-color: #158cba; color: #ffffff; padding: 5px 6px; text-align: left; font-size: 11px; font-weight: bold; border: 1px solid #158cba; }
        table.itens td { border: 1px solid #0000; padding: 5px 6px; vertical-align: middle; font-size: 10px; }

        table.itens tbody tr:nth-child(even) { background-color: #f9f9f9; }

        .vazio { text-align: center; color: #6c757d; margin-top: 40px; font-size: 12px; }
        .rodape { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #6c757d; border-top: 1px solid #dee2e6; padding-top: 0px; }
    </style>
</head>
<body>

<div class="cabecalho">
    <h1>Veículos — Estacione Aqui</h1>
</div>

@if ($vehicles->isEmpty())
    <div class="vazio">
        <p>Nenhum veículo encontrado para este filtro.</p>
    </div>
@else
    <table class="itens">
        <thead>
        <tr>
            <th style="width: 15%;">ID</th>
            <th style="width: 15%;">Marca</th>
            <th style="width: 40%;">Modelo</th>
            <th style="width: 15%;">Cor</th>
            <th style="width: 15%;">Placa</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vehicles as $vehicle)
            <tr>
                <td><b>{{ $vehicle->id }}</b></td>
                <td>{{$vehicle->brand}}</td>
                <td>{{ $vehicle->model }}</td>
                <td>{{ $vehicle->color }}</td>
                <td>{{ $vehicle->plate }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<div class="rodape">Documento gerado em {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
