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
    <!-- Sidebar -->
    <div class="flex">
        <div class="w-64 bg-blue-800 text-white min-h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-egg mr-2"></i>Avícola Lab
                </h1>
                <p class="text-blue-200 text-sm">Sistema de Gestión</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-chart-line mr-2"></i>Dashboard
                </a>
                <a href="{{ route('granjas.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('granjas.*') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-home mr-2"></i>Granjas
                </a>
                <a href="{{ route('lotes.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('lotes.*') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-list mr-2"></i>Lotes
                </a>
                <a href="{{ route('pruebas.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('pruebas.*') ? 'bg-blue-900' : '' }}">
                    <i class="fas fa-flask mr-2"></i>Pruebas
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        @yield('title')
                    </h2>
                    <div class="text-sm text-gray-600">
                        {{ date('d/m/Y') }}
                    </div>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>