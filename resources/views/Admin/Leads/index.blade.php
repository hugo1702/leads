@extends('admin.layouts.app')

@section('title', 'Lista de Leads')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-700">Leads</h1>

            <a href="{{ route('admin.leads.create') }}"
                class="bg-green-600 text-sm flex items-center gap-2 text-white px-4 py-2 rounded-md shadow hover:bg-green-700 transition duration-200">
                <i class="fa fa-plus"></i> Insertar
            </a>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <div class="inline-block min-w-full bg-white shadow-md rounded-lg border">
            <table class="min-w-max divide-y divide-gray-200 w-full">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-3 py-3 text-sm font-medium text-gray-700">Nombre</th>
                        <th class="px-3 py-3 text-sm font-medium text-gray-700">Cliente</th>
                        <th class="px-3 py-3 text-sm font-medium text-gray-700">Valor</th>
                        <th class="px-3 py-3 text-sm font-medium text-gray-700">Asignado a</th>
                        <th class="px-3 py-3 text-sm font-medium text-gray-700">Estado</th>
                        <th class="px-3 py-3 text-sm font-medium text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-left">
                    @forelse ($leads as $lead)
                        <tr>
                            <td class="px-3 py-3 text-sm text-gray-900">{{ $lead->name }}</td>
                            <td class="px-3 py-3 text-sm text-gray-900">{{ $lead->client_name }}</td>
                            <td class="px-3 py-3 text-sm text-gray-900">${{ number_format($lead->value, 2) }} {{ $lead->currency }}</td>
                            <td class="px-3 py-3 text-sm text-gray-900">{{ $lead->assignedTo->name ?? 'No asignado' }}</td>
                            <td class="px-3 py-3 text-sm">
                                @php
                                    $statusColors = [
                                        'abierto' => 'bg-green-100 text-green-700',
                                        'cerrado' => 'bg-red-100 text-red-700',
                                        'pendiente' => 'bg-yellow-100 text-yellow-700',
                                    ];
                                    $color = $statusColors[strtolower($lead->status)] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center border px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </td>
                            <td class="px-3 text-sm text-center">
                                <button onclick="document.getElementById('modal-{{ $lead->id }}').classList.remove('hidden')"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                                    <i class="fa fa-eye"></i> Ver
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div id="modal-{{ $lead->id }}" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
                            <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg relative">
                                <h2 class="text-2xl font-bold mb-8 text-center text-gray-800">Detalle del Lead</h2>
                                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                                    <div><strong>Nombre:</strong> {{ $lead->name }}</div>
                                    <div><strong>Cliente:</strong> {{ $lead->client_name }}</div>
                                    <div><strong>Contacto:</strong> {{ $lead->contact }}</div>
                                    <div><strong>Valor:</strong> ${{ number_format($lead->value, 2) }} {{ $lead->currency }}</div>
                                    <div><strong>Creado por:</strong> {{ $lead->createdBy->name ?? 'N/A' }}</div>
                                    <div><strong>Asignado a:</strong> {{ $lead->assignedTo->name ?? 'No asignado' }}</div>
                                    <div><strong>Inicio:</strong> {{ $lead->start_date }}</div>
                                    <div><strong>Cierre:</strong> {{ $lead->end_date ?? 'Pendiente' }}</div>
                                    <div><strong>Estado:</strong> {{ ucfirst($lead->status) }}</div>
                                    <div class="col-span-2"><strong>Descripción:</strong><br>{{ $lead->description }}</div>
                                </div>

                                <div class="mt-6 text-right">
                                    <button onclick="document.getElementById('modal-{{ $lead->id }}').classList.add('hidden')"
                                        class="bg-gray-600 text-sm hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No hay leads registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
