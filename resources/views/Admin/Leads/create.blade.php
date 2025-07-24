@extends('admin.layouts.app')

@section('title', 'Insertar Lead')

@section('content')
    <x-notification session="success" />
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-notification type="error" :message="$error" />
        @endforeach
    @endif

    <div class="max-w-4xl py-2 mx-auto">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="px-8 py-3 bg-gray-700">
                <h2 class="text-xl font-semibold text-center text-white">Insertar información del nuevo lead</h2>
            </div>

            <div class="p-4">
                <form id="leadForm" action="{{ route('admin.lead.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Grid de 2 columnas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="space-y-1">
                            <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                                Nombre
                            </label>
                            <input type="text" name="name" id="name" required
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="Nombre del lead">
                        </div>

                        <!-- Cliente -->
                        <div class="space-y-1">
                            <label for="client_name" class="flex items-center text-sm font-semibold text-gray-700">
                                Cliente
                            </label>
                            <input type="text" name="client_name" id="client_name" required
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="Nombre del cliente">
                        </div>
                    </div>

                    <!-- Contacto -->
                    <div class="space-y-1">
                        <label for="contact" class="flex items-center text-sm font-semibold text-gray-700">
                            Contacto
                        </label>
                        <input type="text" name="contact" id="contact" required
                            class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                            placeholder="Información de contacto">
                    </div>

                    <!-- Grid de 2 columnas para valor y moneda -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Valor -->
                        <div class="space-y-1">
                            <label for="value" class="flex items-center text-sm font-semibold text-gray-700">
                                Valor
                            </label>
                            <input type="number" step="0.01" name="value" id="value"
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="Ej. 15000.00">
                        </div>

                        <!-- Moneda -->
                        <div class="space-y-1">
                            <label for="currency" class="flex items-center text-sm font-semibold text-gray-700">
                                Moneda
                            </label>
                            <select name="currency" id="currency"
                                class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                <option value="MXN">MXN - Peso</option>
                                <option value="USD">USD - Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                            </select>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="space-y-1">
                        <label for="description" class="flex items-center text-sm font-semibold text-gray-700">
                            Descripción
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300" placeholder="Describe los detalles del lead..."></textarea>
                    </div>

                    <!-- Tipo de asignación -->
                    <div class="space-y-1">
                        <label for="assignment_type" class="flex items-center text-sm font-semibold text-gray-700">
                            Tipo de asignación
                        </label>
                        <select name="assignment_type" id="assignment_type" onchange="toggleManualAssignment(this.value)"
                            class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                            <option value="auto">Automática</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>

                    <!-- Asignación manual -->
                    <div id="manual_assignment" class="space-y-1 hidden">
                        <label for="assigned_to" class="flex items-center text-sm font-semibold text-gray-700">
                            Asignar al operador
                        </label>
                        <select name="assigned_to" id="assigned_to"
                            class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div
                        class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href=""
                            class="bg-red-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-red-700 transition duration-200">
                            Cancelar
                        </a>
                        <button type="submit" id="submitBtn"
                            class="bg-green-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-green-700 transition duration-200">
                            Guardar Lead
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let submitted = false;

        document.getElementById('leadForm').addEventListener('submit', function(e) {
            if (submitted) {
                e.preventDefault();
                return false;
            }

            submitted = true;
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').textContent = 'Guardando...';
        });

        function toggleManualAssignment(value) {
            document.getElementById('manual_assignment').classList.toggle('hidden', value !== 'manual');
        }

    </script>
@endsection
