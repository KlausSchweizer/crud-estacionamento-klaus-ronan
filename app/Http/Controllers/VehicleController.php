<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Client;
use App\Services\EncrypterService;
use Illuminate\Http\Request;

class VehicleController extends CrudController
{

    function save(Request $request, ?string $id = null)
    {
        $decryptedId = null;
        if ($id) {
            $decryptedId = EncrypterService::decrypt($id);
        }

        $request->validate([
            'clients' => 'nullable|array',
            'clients.*' => 'integer|distinct|exists:clients,id',
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'plate' => 'required|min:7|max:7|unique:vehicles,plate,' . $decryptedId,
        ], [
            'brand.required' => 'Insira a marca.',
            'model.required' => 'Insira o modelo.',
            'color.required' => 'Insira a cor.',
            'plate.required' => 'Insira a placa.',
            'plate.min' => 'Insira a placa com 7 dígitos.',
            'plate.max' => 'Insira a placa com 7 dígitos.',
            'plate.unique' => 'Esta placa já existe.'
        ]);

        if ($id) {
            $vehicle = Vehicle::where('id', $decryptedId)->first();
        } else {
            $vehicle = new Vehicle();
        }

        $vehicle->brand = $request->input('brand');
        $vehicle->model = $request->input('model');
        $vehicle->color = $request->input('color');
        $vehicle->plate = strtoupper($request->input('plate'));

        $vehicle->save();
        $vehicle->clients()->sync($request->input('clients', []));

        return redirect()->route('vehicles')->with('success', 'Salvo com sucesso!');
    }

    function createPage()
    {
        return view('vehicles.form', ['clients' => Client::orderBy('name')->get()]);
    }

    function editPage(string $id)
    {
        $decrypted_id = EncrypterService::decrypt($id);
        $vehicle = Vehicle::with('clients')->findOrFail($decrypted_id);
        $clients = Client::orderBy('name')->get();
        return view('vehicles.form', compact('vehicle', 'clients'));
    }

    function delete(string $id)
    {
        $decrypted_id = EncrypterService::decrypt($id);
        $vehicle = Vehicle::find($decrypted_id);
        $vehicle->delete();

        return redirect('/veiculos');
    }

    function view()
    {
        return view('vehicles.vehicles', ['vehicles' => Vehicle::with('clients')->get()]);
    }

}
