<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recibo de pagamento — Estacione Aqui</title>

    <style>
        @page { size: A4 portrait; margin: 1.5cm 1.5cm 1.8cm 1.5cm; }

        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; margin-bottom: 20px; background-color: #ffffff; color: #000000; }

        .cabecalho { border-bottom: 2px solid #000000; padding-bottom: 8px; margin-bottom: 20px; width: 100%; }
        .cabecalho table { width: 100%; border-collapse: collapse; border: none; }
        .cabecalho td { vertical-align: middle; border: none; padding: 0; }

        .logo-box { width: 35px; height: 35px; background-color: #000000; color: #ffffff; text-align: center; font-size: 20px; font-weight: bold; padding-top:5px; box-sizing: border-box }
        .titulo-container { padding-left: 10px; }
        h1 { font-size: 20px; margin: 0; color: #000000; }

        .recibo-container { border: 2px dotted #000000; padding: 20px; margin-top: 10px; }

        .ticket-central { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 25px; border-bottom: 1px solid #000000; padding-bottom: 10px; }

        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { border: none; padding: 5px 0; font-size: 11px; color: #000000; }

        .destaque { font-size: 14px; font-weight: bold; margin-top: 20px; border-top: 1px dashed #000000; padding-top: 10px; text-align: right; }

        .vazio { text-align: center; color: #000000; margin-top: 40px; font-size: 12px; }
        .rodape { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #000000; border-top: 1px solid #000000; padding-top: 5px; }
    </style>
</head>
<body>

<div class="cabecalho">
    <table >
        <tr>
            <td style="width: 35px;">
                <div class="logo-box">P</div>
            </td>
            <td style="width: 10px"></td>
            <td class="titulo-container">
                <h1>Estacione Aqui — Recibo de Pagamento</h1>
            </td>
        </tr>
    </table>
</div>

@if ($parking == null)
    <div class="vazio">
        <p>Ticket não encontrado.</p>
    </div>
@else
    <div class="recibo-container">
        <div class="ticket-central">
            TICKET: {{ $parking->ticket }}
        </div>

        <table class="info-table">
            <tr>
                <td style="text-align: left;"><strong>Data/Hora de Entrada:</strong> {{ $parking->horario_entrada }}</td>
                <td style="text-align: right;"><strong>Data/Hora de Saída:</strong> {{ $parking->horario_saida ?? '' }}</td>
            </tr>
            <tr>
                <td style="text-align: left;" colspan="2"><br><strong>Veículo:</strong> {{ $parking->vehicle->brand ?? '' }} {{ $parking->vehicle->model ?? '' }} — Placa: {{ $parking->vehicle->plate ?? '' }}</td>
            </tr>
            <tr>
                <td style="text-align: left;" colspan="2"><strong>Vaga:</strong> {{ $parking->spot->row ?? '' }}{{ $parking->spot->index ?? '' }}</td>
            </tr>
        </table>

        <div class="destaque">
            VALOR TOTAL: R$ {{ number_format($parking->preco ?? 0, 2, ',', '.') }}
        </div>
    </div>

    <div class="recibo-container ticket-central">
        [CÓDIGO DE BARRAS]
    </div>
@endif

<div class="rodape">Documento gerado em {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
