<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Spot;
use App\Models\Vehicle;
use App\Services\EncrypterService;
use App\Services\PDFService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParkingController extends CrudController
{
    function createPage()
    {
        $vehicles = Vehicle::whereDoesntHave('parkings', function ($query) {
            $query->whereNull('horario_saida');
        })->get();

        $spots = Spot::whereDoesntHave('parking', function ($query) {
            $query->whereNull('horario_saida');
        })->orderBy('row')->orderBy('index')->get();

        return view('parking.form', compact('vehicles', 'spots'));
    }

    function editPage(string $ticket)
    {
        $decryptedTicket = EncrypterService::decrypt($ticket);

        $parking = Parking::where(
            'ticket',
            $decryptedTicket
        )->firstOrFail();

        $vehicles = Vehicle::whereDoesntHave('parkings', function ($query) {
            $query->whereNull('horario_saida');
        })->orWhere('id', $parking->vehicles_id)
            ->get();

        $spots = Spot::whereDoesntHave('parking', function ($query) {
            $query->whereNull('horario_saida');
        })->orWhere('id', $parking->spots_id)
            ->orderBy('row')
            ->orderBy('index')
            ->get();

        return view(
            'parking.form',
            compact('parking', 'vehicles', 'spots')
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

    function registrarSaida(string $ticket, PDFService $PDFService)
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

        $user = session('user');

        $parking->load('vehicle');

        $modelo = $parking->vehicle?->model ?? 'Veículo desconhecido';
        $placa  = $parking->vehicle?->plate ?? 'Sem placa';

        activity()
            ->performedOn($parking)
            ->causedBy($user)
            ->event('Retirada de veículo')
            ->log("O veículo {$modelo} foi retirado do estacionamento. Placa: {$placa}");

        $PDFService->payment($parking);

        return redirect()
            ->back()
            ->with(
                'success',
                'Saída registrada! Valor do ticket: R$ ' .
                number_format($parking->preco, 2, ',', '.')
            );
    }

    function save(Request $request, ?string $id = null)
    {
        $request->validate([
            'vehicles_id' => 'required|exists:vehicles,id',
            'spots_id' => 'required|exists:spots,id',
            'horario_entrada' => 'required',
            'email' => 'email',
        ], [
            'vehicles_id.required' => 'Selecione um veículo.',
            'vehicles_id.exists' => 'Veículo inválido.',
            'spots_id.required' => 'Selecione uma vaga.',
            'spots_id.exists' => 'Vaga inválida.',
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

        $veiculoOcupado = Parking::where('vehicles_id', $request->input('vehicles_id'))
            ->whereNull('horario_saida')
            ->when($id, function ($query) use ($parking) {
                return $query->where('ticket', '!=', $parking->ticket);
            })
            ->exists();

        if ($veiculoOcupado) {
            return back()
                ->withInput()
                ->withErrors(['vehicles_id' => 'Este veículo já possui um estacionamento ativo em outra vaga.']);
        }

        $parking->vehicles_id = $request->input('vehicles_id');
        $parking->spots_id = $request->input('spots_id');
        $parking->horario_entrada = $request->input('horario_entrada');
        $parking->email = $request->input('email');

        $parking->save();

        return redirect()
            ->route('parking')
            ->with('success', 'Ticket cadastrado com sucesso!');
    }

    function view()
    {
        $parkings = Parking::with('vehicle')
            ->orderByRaw('horario_saida IS NULL DESC')
            ->orderBy('ticket', 'desc')
            ->get();

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
