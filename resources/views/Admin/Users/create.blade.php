@extends('admin.layouts.app')

@section('title', 'Insertar usuario')

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
                    <h2 class="text-xl font-semibold text-center text-white">Insertar información del nuevo usuario</h2>
                </div>

                <div class="p-4">

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Grid de 2 columnas para campos principales -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre Completo -->
                            <div class="space-y-1">
                                <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                                    Nombre Completo
                                </label>
                                <input type="text" name="name" id="name" required
                                    class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                    value="{{ old('name') }}" placeholder="Ingrese el nombre completo">
                            </div>

                            <!-- Nombre de Usuario -->
                            <div class="space-y-1">
                                <label for="user_name" class="flex items-center text-sm font-semibold text-gray-700">
                                    Nombre de Usuario
                                </label>
                                <input type="text" name="user_name" id="user_name" required
                                    class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                    value="{{ old('user_name') }}" placeholder="Nombre de usuario único">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label for="email" class="flex items-center text-sm font-semibold text-gray-700">
                                Correo Electrónico
                            </label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                        </div>

                        <!-- Grid de 3 columnas para selects -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Rol -->
                            <div class="space-y-1">
                                <label for="role" class="flex items-center text-sm font-semibold text-gray-700">
                                    Rol
                                </label>
                                <select name="role" id="role" required
                                    class="w-full px-4 py-3 rounded-lg border  text-sm  border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                    <option value="">Seleccione un rol</option>
                                    <option value="operador" {{ old('role') == 'operador' ? 'selected' : '' }}>Operador
                                    </option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador
                                    </option>
                                </select>
                            </div>

                            <!-- Participa en Asignación -->
                            <div class="space-y-1">
                                <label for="participate_assignment"
                                    class="flex items-center text-sm font-semibold text-gray-700">
                                    Asignación automática
                                </label>
                                <select name="participate_assignment" id="participate_assignment" required
                                    class="w-full px-4 py-3 rounded-lg border  text-sm  border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                    <option value="1" {{ old('participate_assignment') == '1' ? 'selected' : '' }}>Sí
                                    </option>
                                    <option value="0" {{ old('participate_assignment') == '0' ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>

                            <!-- Estado Activo -->
                            <div class="space-y-1">
                                <label for="active" class="flex items-center text-sm font-semibold text-gray-700">
                                    Estado
                                </label>
                                <select name="active" id="active" required
                                    class="w-full px-4 py-3 rounded-lg border  text-sm  border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                    <option value="1" {{ old('active') == '1' ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contraseña -->
                            <div class="space-y-1">
                                <label for="password" class="flex items-center text-sm font-semibold text-gray-700">
                                    Contraseña
                                </label>
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 rounded-lg border  text-sm  border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="Mínimo 8 caracteres">
                            </div>
                            <div class="space-y-1">
                                <label for="password_confirmation"
                                    class="flex items-center text-sm font-semibold text-gray-700">
                                    Confirmar Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="Repite la contraseña">
                            </div>

                        </div>

                        <div
                            class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ url()->previous() }}"
                                class="bg-red-600  text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-red-700 transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-green-600  text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-green-700 transition duration-200">
                                <span class="flex items-center justify-center">
                                    Guardar Usuario
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
