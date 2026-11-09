<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Interações e Logs — Estacione Aqui</title>

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

@php
    $eventos = [
        'created'     => 'Cadastro',
        'updated'     => 'Edição',
        'deleted'     => 'Exclusão',
        'restored'    => 'Restauração',
        'visualized'  => 'Visualização',
        'login'       => 'Login',
        'logout'      => 'Logout',
        'retirada'    => 'Retirada',
    ];
@endphp

<div class="cabecalho">
    <h1>Interações e Logs — Estacione Aqui</h1>
</div>

@if ($logs->isEmpty())
    <div class="vazio">
        <p>Nenhum log encontrado para este filtro.</p>
    </div>
@else
    <table class="itens">
        <thead>
        <tr>
            <th style="width: 15%;">Data</th>
            <th style="width: 15%;">Evento</th>
            <th style="width: 40%;">Descrição</th>
            <th style="width: 15%;">Afetado</th>
            <th style="width: 15%;">Realizado por</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                <td><b>{{ $eventos[$log->event] ?? $log->event }}</b></td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->subject?->name ?? $log->subject?->username ?? '—' }}</td>
                <td>{{ $log->causer?->name ?? $log->causer?->username ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<div class="rodape">Documento gerado em {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
