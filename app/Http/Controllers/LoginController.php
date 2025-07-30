<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de manejar la autenticación de usuarios.
 */
class LoginController extends Controller
{

    // Muestra la vista del formulario de inicio de sesión.
    public function show() {
        return view('auth.login');
    }

    //Procesa el inicio de sesión del usuario.
    //Valida las credenciales, verifica si el usuario está activo y redirige al dashboard correspondiente según su rol.
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

    //Cierra la sesión del usuario y redirige al login.
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('welcome') ->with('success', 'Sesión cerrada correctamente');
    }

}
