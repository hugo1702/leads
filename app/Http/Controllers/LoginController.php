<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show() {
        return view('auth.login');
    }


    public function store(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if($user->active !=1) {
                Auth::logout();
                return back()->withErrors(['user_name' => 'Tu cuenta esta inactiva']);
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Inicio de sesión exitoso como administrador');
            } elseif ($user->role === 'operador') {
                return redirect()->route('operator.dashboard')->with('success', 'Inicio de sesión exitoso como operador');
            } else {
                Auth::logout();
                return back()->withErrors(['user_name' => 'Rol no autorizado.']);
            }
        }

        return back()->withErrors([
            'user_name' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente');
    }

}
