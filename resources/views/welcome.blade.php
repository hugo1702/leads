<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión de Leads</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') {{-- Asegúrate de tener Tailwind configurado --}}
</head>

<body class="bg-gradient-to-br from-white  to-gray-300 min-h-screen text-gray-800">

    <!-- HEADER -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between">
            <div class="flex items-center space-x-2 mb-2 sm:mb-0">
                <img src="/assets/images/logo.png" alt="Logo" class="h-8 w-8 object-contain">
                <span class="text-lg sm:text-xl font-bold text-gray-700">Sistema de Gestión de Leads</span>
            </div>

            <div>
                <a href="{{ route('login') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </header>


    <!-- MAIN -->
    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl text-blue-600 md:text-4xl font-extrabold mb-4">Bienvenido a Leads</h2>
            <p class="text-lg text-gray-600">Optimiza tu gestión de usuarios y leads de forma eficiente</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Autenticación -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-4 text-blue-600">1. Autenticación y Usuarios</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li>Inicio y cierre de sesión según rol</li>
                    <li>Validación de estado activo</li>
                    <li>Gestión de usuarios (crear, editar, activar/inactivar)</li>
                    <li>Asignación de roles y seguridad de contraseñas</li>
                </ul>
            </div>

            <!-- Gestión de Leads -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-4 text-blue-600">2. Gestión de Leads</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li>Listado y filtrado por estado</li>
                    <li>Asignación manual o automática (carga mínima)</li>
                    <li>Edición, eliminación y estadísticas</li>
                    <li>Exportación PDF con gráficos</li>
                </ul>
            </div>

            <!-- Dashboards -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-4 text-blue-600">3. Paneles de Control</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li>Dashboard personalizado para administradores</li>
                    <li>Dashboard de operador con leads asignados</li>
                </ul>
            </div>

            <!-- Reportes -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-4 text-blue-600">4. Reportes</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li>PDF de estadísticas por operador</li>
                    <li>Gráficas de leads abiertos vs. cerrados</li>
                </ul>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="text-center text-sm text-gray-500 py-4">
        © {{ date('Y') }} Sistema de Gestión de Leads. Todos los derechos reservados.
    </footer>

</body>

</html>
