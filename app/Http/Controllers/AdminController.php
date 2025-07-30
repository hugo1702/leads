<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth as FacadesAuth;

/**
 * Controlador para el panel de administración.
 */
class AdminController extends Controller
{
    /*
    Muestra la vista principal del dashboard para administradores.
    */
    public function show() {
        return view('admin.dashboard');
    }

    public function showOperator() {
        $userOperator = FacadesAuth::user();

        return view('admin.users.profile', compact('userOperator'));
    }
}
