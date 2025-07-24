<div id="sidebar"
    class="fixed top-16 left-0 z-50 w-64 h-[calc(100vh-4rem)] bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto">

    <!-- Menu -->
    <nav class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 hover:text-gray-800">
            <i class="fa-solid fa-house"></i>
            <span class="ml-3">Home</span>
        </a>
        <a href="{{ route('admin.leads.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 hover:text-gray-800">
            <i class="fa-solid fa-user-plus w-5"></i>
            <span class="ml-3">Leads</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 hover:text-gray-800">
            <i class="fa-solid fa-users w-5"></i>
            <span class="ml-3">Usuarios</span>
        </a>
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 hover:text-gray-800">
            <i class="fa-solid fa-chart-line w-5"></i>
            <span class="ml-3">Reportes</span>
        </a>
    </nav>
</div>
