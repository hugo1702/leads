@extends('admin.layouts.app')

@section('content')
    <div class="mt-4 mx-auto w-full md:w-2/3  bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-6">
            <h2 class="mt-2 text-3xl font-bold text-blue-500">Perfil del Administrador</h2>
            <p class="mt-2 text-gray-500">Información personal y estado de la cuenta</p>
        </div>

        <div class="space-y-5 text-gray-700">
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">👤 Nombre:</span>
                <span class="text-right text-gray-800">{{ $userOperator->name }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">🔑 Usuario:</span>
                <span class="text-right text-gray-800">{{ $userOperator->user_name }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">📶 Estado:</span>
                <span class="text-right font-semibold {{ $userOperator->active ? 'text-green-600' : 'text-red-600' }}">
                    {{ $userOperator->active ? 'Activo' : 'Inactivo' }}
                </span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">📧 Correo:</span>
                <span class="text-right text-gray-800">{{ $userOperator->email }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">🕒 Registro:</span>
                <span class="text-right text-gray-800">{{ $userOperator->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
@endsection
