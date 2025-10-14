<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Avícola - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Mobile Menu Button -->
    <div class="lg:hidden">
        <button id="mobileMenuButton" class="fixed top-4 left-4 z-50 p-2 bg-blue-800 text-white rounded-lg">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="flex">
        <!-- Sidebar - Mobile Friendly -->
        <div id="sidebar"
            class="w-64 bg-blue-800 text-white min-h-screen fixed lg:static transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">
            <div class="p-4 border-b border-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold">
                            <i class="fas fa-egg mr-2"></i>Avícola Lab
                        </h1>
                        <p class="text-blue-200 text-xs">Sistema de Gestión</p>
                    </div>
                    <button id="closeSidebar" class="lg:hidden text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <nav class="mt-4">
                <a href="{{ route('dashboard') }}"
                    class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-chart-line mr-3"></i>Dashboard
                </a>
                <a href="{{ route('granjas.index') }}"
                    class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('granjas.*') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-home mr-3"></i>Granjas
                </a>
                <a href="{{ route('lotes.index') }}"
                    class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('lotes.*') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-list mr-3"></i>Lotes
                </a>
                <a href="{{ route('pruebas.index') }}"
                    class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('pruebas.*') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-flask mr-3"></i>Pruebas
                </a>
                <a href="{{ route('reportes.dashboard-avanzado') }}"
                    class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('reportes.*') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-chart-bar mr-3"></i>Reportes
                </a>

                <a href="{{ route('reportes.comparativas-avanzadas') }}"
                    class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('reportes.comparativas-avanzadas') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-balance-scale mr-3"></i>Comparativas
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 min-h-screen lg:ml-0">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div class="mb-2 sm:mb-0">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-800">
                                @yield('title')
                            </h2>
                            <!-- Breadcrumbs -->
                            <nav class="flex text-xs sm:text-sm text-gray-600 mt-1 flex-wrap">
                                <a href="{{ route('dashboard') }}" class="hover:text-gray-900">Dashboard</a>
                                @yield('breadcrumbs')
                            </nav>
                        </div>
                        <div class="text-xs sm:text-sm text-gray-600">
                            {{ date('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-3 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            mobileMenuButton.addEventListener('click', toggleSidebar);
            closeSidebar.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking on a link (mobile)
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        toggleSidebar();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>