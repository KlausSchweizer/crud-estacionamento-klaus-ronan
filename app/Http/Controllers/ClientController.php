<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\EncrypterService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends CrudController
{
    public function view()
    {
        return view('clients.clients', ['clients' => Client::withCount('vehicles')->orderBy('name')->get()]);
    }

    public function createPage()
    {
        return view('clients.form');
    }

    public function editPage(string $id)
    {
        $client = Client::findOrFail(EncrypterService::decrypt($id));
        return view('clients.form', compact('client'));
    }

    public function save(Request $request, ?string $id = null)
    {
        $client = $id ? Client::findOrFail(EncrypterService::decrypt($id)) : new Client();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($client->id)],
        ]);
        $client->fill($validated)->save();
        return redirect()->route('clients')->with('success', 'Cliente salvo com sucesso!');
    }

    public function delete(string $id)
    {
        Client::findOrFail(EncrypterService::decrypt($id))->delete();
        return redirect()->route('clients')->with('success', 'Cliente excluído com sucesso!');
    }
}
