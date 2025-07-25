@extends('admin.layouts.app')

@section('title', 'Editar Lead')

@section('content')
    <x-notification session="success" />
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-notification type="error" :message="$error" />
        @endforeach
    @endif

    <div class="max- py-2 mx-auto">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="px-8 py-3 bg-gray-700">
                <h2 class="text-xl font-semibold text-center text-white">Editar información del lead</h2>
            </div>

            <div class="p-4">
                <form id="leadForm" action="{{ route('admin.leads.update', $lead->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="name" class="flex items-center text-sm font-semibold text-gray-700">Nombre</label>
                            <input type="text" name="name" id="name" required
                                value="{{ old('name', $lead->name) }}"
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="Nombre del lead">
                        </div>

                        <div class="space-y-1">
                            <label for="client_name" class="flex items-center text-sm font-semibold text-gray-700">Cliente</label>
                            <input type="text" name="client_name" id="client_name" required
                                value="{{ old('client_name', $lead->client_name) }}"
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="Nombre del cliente">
                        </div>

                        <div class="space-y-1">
                            <label for="contact" class="flex items-center text-sm font-semibold text-gray-700">Contacto</label>
                            <input type="text" name="contact" id="contact" required
                                value="{{ old('contact', $lead->contact) }}"
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="Información de contacto">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label for="value" class="flex items-center text-sm font-semibold text-gray-700">Valor</label>
                            <input type="number" step="0.01" name="value" id="value"
                                value="{{ old('value', $lead->value) }}"
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                                placeholder="Ej. 15000.00">
                        </div>

                        <div class="space-y-1">
                            <label for="currency" class="flex items-center text-sm font-semibold text-gray-700">Moneda</label>
                            <select name="currency" id="currency"
                                class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                <option value="MXN" @selected(old('currency', $lead->currency) === 'MXN')>MXN - Peso</option>
                                <option value="USD" @selected(old('currency', $lead->currency) === 'USD')>USD - Dollar</option>
                                <option value="EUR" @selected(old('currency', $lead->currency) === 'EUR')>EUR - Euro</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="description" class="flex items-center text-sm font-semibold text-gray-700">Descripción</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300"
                            placeholder="Describe los detalles del lead...">{{ old('description', $lead->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label for="assignment_type" class="flex items-center text-sm font-semibold text-gray-700">Tipo de asignación</label>
                            <select name="assignment_type" id="assignment_type"
                                onchange="toggleManualAssignment(this.value)"
                                class="w-full px-4 py-3 rounded-lg border text-sm border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50 focus:bg-white">
                                <option value="auto" @selected(old('assignment_type', $lead->assigned_to ? 'manual' : 'auto') === 'auto')>Automática</option>
                                <option value="manual" @selected(old('assignment_type', $lead->assigned_to ? 'manual' : 'auto') === 'manual')>Manual</option>
                            </select>
                        </div>

                        <div id="manual_assignment" class="space-y-1 {{ old('assignment_type', $lead->assigned_to ? 'manual' : 'auto') === 'manual' ? '' : 'hidden' }}">
                            <label for="assigned_to" class="flex items-center text-sm font-semibold text-gray-700">Asignar al operador</label>
                            <select name="assigned_to" id="assigned_to"
                                class="w-full px-3 py-3 text-sm rounded-lg border border-gray-300">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_to', $lead->assigned_to) == $user->id)>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.leads.index') }}"
                            class="bg-red-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-red-700 transition duration-200">
                            Cancelar
                        </a>
                        <button type="submit" id="submitBtn"
                            class="bg-blue-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 transition duration-200">
                            Actualizar Lead
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
            document.getElementById('submitBtn').textContent = 'Actualizando...';
        });

        function toggleManualAssignment(value) {
            document.getElementById('manual_assignment').classList.toggle('hidden', value !== 'manual');
        }
    </script>
@endsection
