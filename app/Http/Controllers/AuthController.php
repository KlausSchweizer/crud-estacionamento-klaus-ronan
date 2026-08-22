<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ],
        [
            'email.required' => 'Insira o e-mail.',
            'email.email' => 'Insira um e-mail válido.',
            'password.required' => 'Insira a senha.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)
            ->whereNull('deleted_at')
            ->first();

        if(!$user) {
            return redirect()->back()->withInput()->withErrors(['login_error' => 'Campo de e-mail ou senha incorreto']);
        }

        if(!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->withErrors(['login_error' => 'Campo de e-mail ou senha incorreto']);
        }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();
        session(['user' => $user]);

        return redirect('/');
    }

    public function logout() {
        session()->forget('user');
        return redirect()->route('auth.login');
    }
}
