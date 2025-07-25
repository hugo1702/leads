<div id="sidebar"
    class="fixed top-16 left-0 z-50 w-64 h-[calc(100vh-4rem)] bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto">

    <nav class="mt-6">
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 hover:text-gray-800">
            <i class="fa-solid fa-house"></i>
            <span class="ml-3">Home</span>
        </a>
        <a href="{{ route('operator.leads.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 hover:text-gray-800">
            <i class="fa-solid fa-house"></i>
            <span class="ml-3">Leads</span>
        </a>
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 hover:text-gray-800">
            <i class="fa-solid fa-user w-5"></i>
            <span class="ml-3">Mi perfil</span>
        </a>
    </nav>
</div>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('leads-dropdown');
        const icon = document.getElementById('dropdown-icon');

        dropdown.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
</script>
