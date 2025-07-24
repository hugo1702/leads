@extends('admin.layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <x-notification session="success" />
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-notification type="error" :message="$error" />
        @endforeach
    @endif

    <div>
        <div class="max-w-4xl py-2 mx-auto">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="px-8 py-3 bg-gray-700">
                    <h2 class="text-xl font-semibold text-center text-white">Editar información del usuario</h2>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label for="name" class="text-sm font-semibold text-gray-700">Nombre Completo</label>
                                <input type="text" name="name" id="name" required
                                    class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                    value="{{ old('name', $user->name) }}">
                            </div>

                            <div class="space-y-1">
                                <label for="user_name" class="text-sm font-semibold text-gray-700">Nombre de Usuario</label>
                                <input type="text" name="user_name" id="user_name" disabled
                                    class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                    value="{{ old('user_name', $user->user_name) }}">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="email" class="text-sm font-semibold text-gray-700">Correo Electrónico</label>
                            <input type="email" name="email" id="email" disabled
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-1">
                                <label for="role" class="text-sm font-semibold text-gray-700">Rol</label>
                                <select name="role" id="role" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300">
                                    <option value="operador" {{ old('role', $user->role) == 'operador' ? 'selected' : '' }}>
                                        Operador
                                    </option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                        Administrador
                                    </option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="participate_assignment"
                                    class="text-sm font-semibold text-gray-700">Asignación automática</label>
                                <select name="participate_assignment" id="participate_assignment" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300">
                                    <option value="1"
                                        {{ old('participate_assignment', $user->participate_assignment) == '1' ? 'selected' : '' }}>
                                        Sí
                                    </option>
                                    <option value="0"
                                        {{ old('participate_assignment', $user->participate_assignment) == '0' ? 'selected' : '' }}>
                                        No
                                    </option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="active" class="text-sm font-semibold text-gray-700">Estado</label>
                                <select name="active" id="active" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300">
                                    <option value="1" {{ old('active', $user->active) == '1' ? 'selected' : '' }}>
                                        Activo</option>
                                    <option value="0" {{ old('active', $user->active) == '0' ? 'selected' : '' }}>
                                        Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label for="password" class="text-sm font-semibold text-gray-700">Contraseña
                                    (opcional)</label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300"
                                    placeholder="Solo si deseas cambiarla">
                            </div>
                            <div class="space-y-1">
                                <label for="password_confirmation" class="text-sm font-semibold text-gray-700">Confirmar
                                    Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300"
                                    placeholder="Repite la nueva contraseña">
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ url()->previous() }}"
                                class="bg-red-600 text-sm text-white px-4 py-2 rounded-md shadow hover:bg-red-700">Cancelar</a>
                            <button type="submit"
                                class="bg-green-600 text-sm text-white px-4 py-2 rounded-md shadow hover:bg-green-700">Actualizar
                                Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
