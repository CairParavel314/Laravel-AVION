@extends('layouts.app')

@section('title', 'Gestión de Granjas')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header Responsive -->
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
            <div>
                <h3 class="text-lg sm:text-xl font-medium text-gray-900">Lista de Granjas</h3>
                <p class="text-sm text-gray-600 mt-1 hidden sm:block">Gestión completa de granjas avícolas</p>
            </div>
            <a href="{{ route('granjas.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm sm:text-base inline-flex items-center justify-center w-full sm:w-auto">
                <i class="fas fa-plus mr-2"></i>Nueva Granja
            </a>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
            @foreach($granjas as $granja)
            <div class="border border-gray-200 rounded-lg p-4 sm:p-6 hover:shadow-md transition">
                <!-- Header de la tarjeta -->
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <div class="flex items-center min-w-0 flex-1">
                        <div class="p-2 bg-blue-100 rounded-lg flex-shrink-0">
                            <i class="fas fa-home text-blue-600 text-sm sm:text-base"></i>
                        </div>
                        <div class="ml-3 min-w-0 flex-1">
                            <a href="{{ route('granjas.show', $granja) }}" 
                               class="text-base sm:text-lg font-semibold text-gray-900 hover:text-blue-600 transition truncate block">
                                {{ $granja->nombre }}
                            </a>
                            <p class="text-xs text-gray-500 mt-1 truncate">{{ $granja->ubicacion }}</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded flex-shrink-0 ml-2">
                        {{ $granja->lotes_count }}
                    </span>
                </div>
                
                <!-- Información de contacto -->
                <div class="space-y-2 text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2 text-gray-400 w-4 flex-shrink-0"></i>
                        <span class="truncate">{{ $granja->responsable }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone mr-2 text-gray-400 w-4 flex-shrink-0"></i>
                        <span class="truncate">{{ $granja->telefono ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-gray-400 w-4 flex-shrink-0"></i>
                        <span class="truncate">{{ $granja->email ?? 'N/A' }}</span>
                    </div>
                </div>
                
                <!-- Descripción -->
                <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-200">
                    <p class="text-xs sm:text-sm text-gray-500 line-clamp-2">
                        {{ $granja->descripcion ? Str::limit($granja->descripcion, 80) : 'Sin descripción' }}
                    </p>
                </div>

                <!-- Acciones -->
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('granjas.show', $granja )}}"
                        class="flex-1 min-w-[60px] bg-blue-50 text-blue-700 py-2 px-2 rounded text-xs hover:bg-blue-100 transition text-center flex items-center justify-center"
                        title="Ver detalles">
                        <i class="fas fa-eye mr-1 sm:mr-2"></i>
                        <span class="hidden sm:inline">Ver</span>
                    </a>
                    <a href="{{ route('lotes.create') }}?granja_id={{ $granja->id }}"
                        class="flex-1 min-w-[60px] bg-green-50 text-green-700 py-2 px-2 rounded text-xs hover:bg-green-100 transition text-center flex items-center justify-center"
                        title="Crear lote">
                        <i class="fas fa-plus mr-1 sm:mr-2"></i>
                        <span class="hidden sm:inline">Lote</span>
                    </a>
                    <a href="{{ route('granjas.edit', $granja )}}"
                        class="flex-1 min-w-[60px] bg-yellow-50 text-yellow-700 py-2 px-2 rounded text-xs hover:bg-yellow-100 transition text-center flex items-center justify-center"
                        title="Editar granja">
                        <i class="fas fa-edit mr-1 sm:mr-2"></i>
                        <span class="hidden sm:inline">Editar</span>
                    </a>
                    <form action="{{ route('granjas.destroy', $granja) }}" method="POST" class="flex-1 min-w-[60px]">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-50 text-red-700 py-2 px-2 rounded text-xs hover:bg-red-100 transition flex items-center justify-center"
                            onclick="return confirm('¿Está seguro de eliminar esta granja?')"
                            title="Eliminar granja">
                            <i class="fas fa-trash mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Eliminar</span>
                        </button>
                    </form>
                </div>

                <!-- Acciones rápidas móvil -->
                <div class="mt-3 pt-3 border-t border-gray-200 sm:hidden">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>{{ $granja->lotes_count }} lotes</span>
                        <span>{{ Str::limit($granja->ubicacion, 15) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($granjas->isEmpty())
            <div class="text-center py-8 sm:py-12">
                <div class="bg-gray-50 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-home text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay granjas registradas</h3>
                <p class="text-gray-500 text-sm mb-6">Comienza creando tu primera granja</p>
                <a href="{{ route('granjas.create') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-flex items-center text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Crear primera granja
                </a>
            </div>
        @endif


    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @media (max-width: 640px) {
        .min-w-0 {
            min-width: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mejorar la experiencia táctil en móviles
        const cards = document.querySelectorAll('.border-gray-200.rounded-lg');
        cards.forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            card.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection