@extends('admin.layouts.app')

@section('title', 'Lista de usuarios')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 py-4">
        <div class="flex items-center justify-between ">
            <h1 class="text-3xl font-bold text-gray-700">Usuarios</h1>

            <div class="flex flex-col sm:flex-row gap-2">
                @php
                    $filtroInactivos = request('inactivos');
                @endphp

                <a href="{{ route('admin.users.index', ['inactivos' => $filtroInactivos ? null : 1]) }}"
                    class="{{ $filtroInactivos ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow transition duration-200">
                    <i class="fa fa-users"></i>
                    {{ $filtroInactivos ? 'Usuarios Activos' : 'Usuarios Inactivos' }}
                </a>

                <a href="{{ route('admin.users.create') }}"
                    class="bg-green-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-green-700 transition duration-200">
                    <i class="fa fa-plus"></i>
                    Insertar
                </a>
            </div>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
    <div class="inline-block min-w-full bg-white shadow-md rounded-lg border">
        <table class="min-w-max divide-y divide-gray-200 w-full">
            <thead class="bg-gray-100 text-left ">
                <tr>
                    <th class="px-3 py-3 text-sm font-medium text-gray-700">Nombre</th>
                    <th class="px-3 py-3 text-sm font-medium text-gray-700">Email</th>
                    <th class="px-3 py-3 text-sm font-medium text-gray-700">Rol</th>
                    <th class="px-3 py-3 text-sm font-medium text-gray-700">Usuario</th>
                    <th class="px-3 py-3 text-sm font-medium text-gray-700">Asignación</th>
                    <th class="px-3 py-3 text-sm font-medium text-gray-700">Estado</th>
                    <th class="px-3 py-3 text-sm font-medium text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-left">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-3 py-3 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-3 py-3 text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-3 py-3 text-sm text-gray-900">{{ ucfirst($user->role) }}</td>
                        <td class="px-3 py-3 text-sm text-gray-900">{{ $user->user_name }}</td>
                        <td class="px-3 py-3 text-sm text-gray-900">
                            @if ($user->participate_assignment)
                                <span
                                    class="inline-flex items-center border px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Automática
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center border px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    Manual
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-sm text-gray-900">
                            @if ($user->active)
                                <span
                                    class="inline-flex items-center border px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Activo</span>
                            @else
                                <span
                                    class="inline-flex items-center border px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-3 text-sm text-center">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No hay usuarios.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt bg-white text-gray-800 p-4 rounded-md shadow [&_*]:!bg-white [&_*]:!text-gray-800">
        {{ $users->links() }}
    </div>
    </div>
@endsection
