<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Avícola - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos para prevenir comportamientos no deseados */
        a, button, input, textarea, select {
            outline: none !important;
        }
        
        .sidebar-link {
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0.5rem 1rem;
            color: white;
            text-decoration: none;
        }
        
        .sidebar-link:hover {
            background-color: #1e40af;
        }
        
        .sidebar-link.active {
            background-color: #1e3a8a;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex">
        <div class="w-64 bg-blue-800 text-white min-h-screen fixed">
            <div class="p-4">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-egg mr-2"></i>Avícola Lab
                </h1>
                <p class="text-blue-200 text-sm">Sistema de Gestión</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line mr-2"></i>Dashboard
                </a>
                <a href="{{ route('granjas.index') }}" 
                   class="sidebar-link {{ request()->routeIs('granjas.*') ? 'active' : '' }}">
                    <i class="fas fa-home mr-2"></i>Granjas
                </a>
                <a href="{{ route('lotes.index') }}" 
                   class="sidebar-link {{ request()->routeIs('lotes.*') ? 'active' : '' }}">
                    <i class="fas fa-list mr-2"></i>Lotes
                </a>
                <a href="{{ route('pruebas.index') }}" 
                   class="sidebar-link {{ request()->routeIs('pruebas.*') ? 'active' : '' }}">
                    <i class="fas fa-flask mr-2"></i>Pruebas
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        @yield('title')
                    </h2>
                    <!-- Breadcrumbs -->
                    <nav class="flex text-sm text-gray-600 mt-1">
                        <a href="{{ route('dashboard') }}" class="hover:text-gray-900">Dashboard</a>
                        @yield('breadcrumbs')
                    </nav>
                </div>
                <div class="text-sm text-gray-600">
                    {{ date('d/m/Y') }}
                </div>
            </div>
        </div>
    </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script para prevenir comportamientos no deseados -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevenir clics accidentales en elementos que no son enlaces
            document.addEventListener('click', function(e) {
                // Si el elemento clickeado no es un enlace, botón o input
                if (!e.target.closest('a') && 
                    !e.target.closest('button') && 
                    !e.target.closest('input') && 
                    !e.target.closest('select') && 
                    !e.target.closest('textarea')) {
                    
                    // Solo prevenir si el target es el body o un elemento sin interacción
                    if (e.target === document.body || 
                        e.target.classList.contains('bg-gray-100') ||
                        e.target.classList.contains('flex') ||
                        e.target.classList.contains('flex-1')) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }
            });

            // Agregar event listeners específicos para los enlaces del sidebar
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    console.log('Navegando a:', this.href);
                    // El comportamiento normal del enlace se mantiene
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>