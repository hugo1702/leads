@extends('admin.layouts.app')

@section('title', 'Insertar Lead')

@section('content')
<div class="max-full mx-auto bg-white p-6 rounded shadow">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Leads</p>
                    <p class="text-3xl font-bold text-gray-900" id="totalLeads">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Leads Abiertos</p>
                    <p class="text-3xl font-bold text-blue-600" id="totalAbiertos">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Leads Cerrados</p>
                    <p class="text-3xl font-bold text-green-600" id="totalCerrados">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Tasa de Conversión</p>
                    <p class="text-3xl font-bold text-purple-600" id="tasaConversion">0%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <h1 class="text-2xl font-bold mb-8 text-center">Gráfica de Leads por Operador</h1>
    <canvas id="leadsChart" height="100"></canvas>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('leadsChart').getContext('2d');

    // Datos desde PHP
    const abiertos = {!! json_encode($operadoresConStats->pluck('abiertos')) !!};
    const cerrados = {!! json_encode($operadoresConStats->pluck('cerrados')) !!};

    // Calcular totales
    const totalAbiertos = abiertos.reduce((a, b) => a + b, 0);
    const totalCerrados = cerrados.reduce((a, b) => a + b, 0);
    const totalLeads = totalAbiertos + totalCerrados;
    const tasaConversion = totalLeads > 0 ? ((totalCerrados / totalLeads) * 100).toFixed(1) : 0;

    // Actualizar contadores con animación
    function animateNumber(element, finalNumber, suffix = '') {
        let currentNumber = 0;
        const increment = finalNumber / 30;
        const timer = setInterval(() => {
            currentNumber += increment;
            if (currentNumber >= finalNumber) {
                currentNumber = finalNumber;
                clearInterval(timer);
            }
            element.textContent = Math.floor(currentNumber) + suffix;
        }, 50);
    }

    animateNumber(document.getElementById('totalLeads'), totalLeads);
    animateNumber(document.getElementById('totalAbiertos'), totalAbiertos);
    animateNumber(document.getElementById('totalCerrados'), totalCerrados);
    animateNumber(document.getElementById('tasaConversion'), parseFloat(tasaConversion), '%');

    // Gráfica original con ligeras mejoras
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($operadoresConStats->pluck('nombre')) !!},
            datasets: [{
                    label: 'Leads Abiertos',
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    data: abiertos
                },
                {
                    label: 'Leads Cerrados',
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    data: cerrados
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection
