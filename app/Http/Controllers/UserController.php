<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador para gestionar usuarios (operadores) desde el panel de administración.
 */

class UserController extends Controller
{

    //Muestra una lista paginada de usuarios con filtros opcionales por estado y rol.
    public function index()
    {
        $filtroInactivos = request('inactivos');
        $filtroRol = request('role');

        $users = User::when($filtroInactivos, function ($query) {
            return $query->where('active', 0);
        }, function ($query) {
            return $query->where('active', 1);
        })
            ->when($filtroRol, function ($query, $filtroRol) {
                return $query->where('role', $filtroRol);
            })
            ->paginate(8);

        return view('admin.users.index', compact('users'));
    }

    //Muestra el formulario para crear un nuevo usuario.
    public function create()
    {
        return view('admin.users.create');
    }

    // Almacena un nuevo usuario en la base de datos después de validar los datos del formulario.
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'participate_assignment' => 'required|boolean',
            'active' => 'required|boolean',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->user_name = $validated['user_name'];
        $user->email = $validated['email'];
        $user->role = 'operador';
        $user->participate_assignment = $validated['participate_assignment'];
        $user->active = $validated['active'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Operador creado exitosamente.');
    }


    // Muestra el formulario para editar un usuario existente.
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /* Actualiza la información de un usuario existente.
    Si se proporciona una nueva contraseña, también se actualiza.*/
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'participate_assignment' => 'required|boolean',
            'active' => 'required|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->participate_assignment = $validated['participate_assignment'];
        $user->active = $validated['active'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Operador actualizado correctamente');
    }
}
