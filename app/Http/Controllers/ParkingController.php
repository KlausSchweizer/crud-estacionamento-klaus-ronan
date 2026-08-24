<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Vehicle;
use App\Services\EncrypterService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParkingController extends CrudController
{
    function save(Request $request, ?string $id = null)
    {
        $request->validate([
            'vehicles_id' => 'required|exists:vehicles,id',
            'horario_entrada' => 'required',
        ], [
            'vehicles_id.required' => 'Selecione um veículo.',
            'vehicles_id.exists' => 'Veículo inválido.',
            'horario_entrada.required' => 'Insira o horário de entrada.',
        ]);

        if ($id) {
            $decryptedTicket = EncrypterService::decrypt($id);

            $parking = Parking::where(
                'ticket',
                $decryptedTicket
            )->firstOrFail();
        } else {
            $parking = new Parking();
        }

        $parking->vehicles_id = $request->input('vehicles_id');
        $parking->horario_entrada = $request->input('horario_entrada');

        $parking->save();

        return redirect()
            ->route('parking')
            ->with('success', 'Ticket cadastrado com sucesso!');
    }

    function createPage()
    {
        $vehicles = Vehicle::all();

        return view('parking.form', compact('vehicles'));
    }

    function editPage(string $ticket)
    {
        $decryptedTicket = EncrypterService::decrypt($ticket);

        $parking = Parking::where(
            'ticket',
            $decryptedTicket
        )->firstOrFail();

        $vehicles = Vehicle::all();

        return view(
            'parking.form',
            compact('parking', 'vehicles')
        );
    }

    function delete(string $id)
    {
        $decryptedTicket = EncrypterService::decrypt($id);

        $parking = Parking::where(
            'ticket',
            $decryptedTicket
        )->firstOrFail();

        $parking->delete();

        return redirect()
            ->route('parking')
            ->with('success', 'Ticket excluído com sucesso!');
    }

    function registrarSaida(string $ticket)
    {
        $decryptedTicket = EncrypterService::decrypt($ticket);

        $parking = Parking::where(
            'ticket',
            $decryptedTicket
        )->firstOrFail();

        if ($parking->horario_saida) {
            return redirect()
                ->route('parking')
                ->with('success', 'A saída deste veículo já foi registrada.');
        }

        $entrada = Carbon::parse($parking->horario_entrada);

        $saida = Carbon::now();

        if ($entrada->greaterThan($saida)) {
            $entrada->subDay();
        }

        $minutos = $entrada->diffInMinutes($saida);

        $horas = $minutos / 60;

        $preco = $horas * 10;

        $parking->horario_saida = $saida->format('H:i:s');
        $parking->preco = round($preco, 2);

        $parking->save();

        return redirect()
            ->route('parking')
            ->with(
                'success',
                'Saída registrada! Valor do ticket: R$ ' .
                number_format($parking->preco, 2, ',', '.')
            );
    }

    function view()
    {
        $parkings = Parking::with('vehicle')->get();

        return view(
            'parking.parking',
            compact('parkings')
        );
    }

    function findById(string $ticket)
    {
        $decryptedTicket = EncrypterService::decrypt($ticket);

        return Parking::where(
            'ticket',
            $decryptedTicket
        )->firstOrFail();
    }
}
