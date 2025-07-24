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
                    <form action="{{ route('admin.users.store') }}" id="userForm" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                                    Nombre Completo
                                </label>
                                <input type="text" name="name" id="name" required
                                    class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                    placeholder="Ingrese el nombre completo">
                            </div>

                            <div class="space-y-1">
                                <label for="user_name" class="flex items-center text-sm font-semibold text-gray-700">
                                    Nombre de Usuario
                                </label>
                                <input type="text" name="user_name" id="user_name" required
                                    class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                    placeholder="Nombre de usuario único">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="email" class="flex items-center text-sm font-semibold text-gray-700">
                                Correo Electrónico
                            </label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="correo@ejemplo.com">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-1">
                                <label for="role" class="flex items-center text-sm font-semibold text-gray-700">
                                    Rol
                                </label>
                                <select name="role" id="role" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                    <option value="">Seleccione un rol</option>
                                    <option value="operador">Operador</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="participate_assignment"
                                    class="flex items-center text-sm font-semibold text-gray-700">
                                    Asignación automática
                                </label>
                                <select name="participate_assignment" id="participate_assignment" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="active" class="flex items-center text-sm font-semibold text-gray-700">
                                    Estado
                                </label>
                                <select name="active" id="active" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label for="password" class="flex items-center text-sm font-semibold text-gray-700">
                                    Contraseña
                                </label>
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white"
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

                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.users.index') }}"
                                class="bg-red-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-red-700 transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit" id="submitBtn"
                                class="bg-green-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-green-700 transition duration-200">
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

<script>
        let submitted = false;

        document.getElementById('userForm').addEventListener('submit', function(e) {
            if (submitted) {
                e.preventDefault();
                return false;
            }

            submitted = true;
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').textContent = 'Guardando...';
        });
    </script>
