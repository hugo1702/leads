<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

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

    public function create()
    {
        return view('admin.users.create');
    }

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

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

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
