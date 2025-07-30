{{-- resources/views/admin/components/navbar.blade.php --}}
<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-60">
    <div class="mmax-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-4">
                <button id="menu-toggle" class="lg:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-1">
                    <img src="/assets/images/logo.png" alt="Logo" class="h-6 w-6 object-contain" />
                    <span class="text-xl font-bold text-gray-600 px"> Panel Administrativo</span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden sm:flex items-center space-x-3">
                    <a href="{{ route('admin.users.profile')}}"
                        class="hidden sm:flex items-center space-x-3 cursor-pointer hover:text-gray-900">
                        <div class="text-sm text-gray-700">
                            <span class="font-medium">{{ auth()->user()->name ?? 'Usuario' }}</span>
                        </div>
                        <div class="h-8 w-8 bg-blue-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-sm"></i>
                        </div>
                    </a>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-sign-out-alt lg:mr-2"></i>
                        <span class="hidden lg:inline ml-1">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
