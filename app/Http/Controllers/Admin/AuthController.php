<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
{
    $credenciales = $request->validate([
        'email' => ['required'],   // <- se quitó la regla 'email'
        'password' => ['required'],
    ]);

    if (Auth::attempt($credenciales, $request->boolean('recordarme'))) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors([
        'email' => 'Credenciales incorrectas.',
    ])->onlyInput('email');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}