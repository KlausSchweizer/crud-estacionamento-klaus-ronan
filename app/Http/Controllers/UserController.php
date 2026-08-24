<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EncrypterService;
use Illuminate\Http\Request;

class UserController extends CrudController
{
    public function save(Request $request, ?string $id = null)
    {
        $decryptedId = null;
        if ($id) {
            $decryptedId = EncrypterService::decrypt($id);
        }

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $decryptedId,
            'password' => 'nullable|min:6',
        ], [
            'username.required' => 'Insira o nome.',
            'email.required' => 'Insira um e-mail válido.',
            'email.email' => 'Insira um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ]);

        if ($id) {
            $user = User::where('id', $decryptedId)->first();
        } else {
            $user = new User();
            $user->password = bcrypt('senha123');
        }

        $user->username = $request->input('username');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('users')->with('success', 'Salvo com sucesso!');
    }

    public function update(Request $request)
    {

    }

    public function delete(string $id)
    {
        $decrypted_id = EncrypterService::decrypt($id);
        $user = User::find($decrypted_id);
        $user->delete();

        return redirect('/usuarios');
    }

    public function view()
    {
        return view('users.users', ['users' => User::all()]);
    }

    public function editPage(string $id)
    {
        $decrypted_id = EncrypterService::decrypt($id);
        $user = User::where('id', '=', $decrypted_id)->first();
        return view('users.form', compact('user'));
    }

    public function createPage()
    {
        return view('users.form');
    }
}
