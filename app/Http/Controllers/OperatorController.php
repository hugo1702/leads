<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

/**
 * Controlador para el panel de operador.
 */
class OperatorController extends Controller
{
    /*
     * Muestra la vista principal del dashboard para operadores.
     */
    public function show() {
        return view('operator.dashboard');
    }

    public function showOperator() {
        $userOperator = FacadesAuth::user();

        return view('operator.users.profile', compact('userOperator'));
    }
}
