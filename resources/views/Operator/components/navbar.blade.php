{{-- resources/views/admin/components/navbar.blade.php --}}
<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-60">
    <div class="max-w-7xl mx-auto sm:px-2">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-4">
                <button id="menu-toggle" class="lg:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <a href="#" class="flex items-center space-x-1">
                        <img src="/assets/images/logo.png" alt="Logo" class="h-6 w-6 object-contain" />
                        <span class="text-xl font-bold text-gray-600 px"> Panel de operador</span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden sm:flex items-center space-x-3">
                    <div class="text-sm text-gray-700">
                        <span class="font-medium">{{ auth()->user()->name ?? 'Usuario' }}</span>
                    </div>
                    <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600 text-sm"></i>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-sign-out-alt lg:mr-2"></i>
                        <span class="hidden lg:inline ml-1">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
