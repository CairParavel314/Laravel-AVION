@extends('layouts.app')

@section('title', 'Gestión de Pruebas')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header Responsive -->
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
            <div>
                <h3 class="text-lg sm:text-xl font-medium text-gray-900">Historial de Pruebas</h3>
                <p class="text-sm text-gray-600 mt-1 hidden sm:block">Registro completo de pruebas de laboratorio</p>
            </div>
            <a href="{{ route('pruebas.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm sm:text-base inline-flex items-center justify-center w-full sm:w-auto">
                <i class="fas fa-plus mr-2"></i>Nueva Prueba
            </a>
        </div>
    </div>
    
    <div class="p-3 sm:p-6">
        <div class="overflow-x-auto -mx-2 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lote</th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden sm:table-cell">Tipo</th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parámetro</th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Valor</th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Resultado</th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">Fecha</th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden xl:table-cell">Realizada Por</th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($pruebas as $prueba)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Columna Lote -->
                            <td class="px-2 sm:px-4 py-3">
                                <div class="min-w-0">
                                    <a href="{{ route('lotes.show', $prueba->lote) }}" 
                                       class="text-blue-600 hover:text-blue-900 font-medium text-xs sm:text-sm block truncate">
                                        {{ $prueba->lote->codigo_lote }}
                                    </a>
                                    <a href="{{ route('granjas.show', $prueba->lote->granja) }}" 
                                       class="text-xs text-gray-500 hover:text-gray-700 block mt-1 truncate sm:hidden">
                                        {{ \Illuminate\Support\Str::limit($prueba->lote->granja->nombre, 15) }}
                                    </a>
                                    <div class="hidden sm:block">
                                        <span class="text-xs text-gray-500">
                                            {{ \Illuminate\Support\Str::limit($prueba->tipo_prueba, 8) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Columna Tipo Prueba (oculta en móvil) -->
                            <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                                {{ ucfirst($prueba->tipo_prueba) }}
                            </td>
                            
                            <!-- Columna Parámetro -->
                            <td class="px-2 sm:px-4 py-3">
                                <div class="min-w-0">
                                    <span class="text-xs sm:text-sm text-gray-900 font-medium block truncate">
                                        {{ \Illuminate\Support\Str::limit($prueba->parametro, 12) }}
                                    </span>
                                    <div class="sm:hidden text-xs text-gray-500 mt-1">
                                        {{ $prueba->valor }} {{ $prueba->unidad_medida }}
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Columna Valor (oculta en móvil y tablet pequeña) -->
                            <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                {{ $prueba->valor }} {{ $prueba->unidad_medida }}
                            </td>
                            
                            <!-- Columna Resultado -->
                            <td class="px-2 sm:px-4 py-3">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $prueba->resultado == 'normal' ? 'bg-green-100 text-green-800' : 
                                       ($prueba->resultado == 'anormal' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    <span class="hidden sm:inline">{{ ucfirst($prueba->resultado) }}</span>
                                    <span class="sm:hidden">{{ substr(ucfirst($prueba->resultado), 0, 1) }}</span>
                                </span>
                            </td>
                            
                            <!-- Columna Fecha (oculta en móvil y tablet) -->
                            <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm text-gray-900 hidden lg:table-cell">
                                {{ \Carbon\Carbon::parse($prueba->fecha_prueba)->format('d/m/Y') }}
                            </td>
                            
                            <!-- Columna Realizada Por (oculta en móvil, tablet y desktop pequeño) -->
                            <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm text-gray-900 hidden xl:table-cell">
                                <span class="truncate block max-w-[120px]">
                                    {{ \Illuminate\Support\Str::limit($prueba->realizada_por, 15) }}
                                </span>
                            </td>
                            
                            <!-- Columna Acciones -->
                            <td class="px-2 sm:px-4 py-3">
                                <div class="flex space-x-1 sm:space-x-2">
                                    <a href="{{ route('pruebas.show', $prueba) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition"
                                       title="Ver detalles">
                                        <i class="fas fa-eye text-xs sm:text-sm"></i>
                                    </a>
                                    <a href="{{ route('pruebas.edit', $prueba) }}" 
                                       class="text-green-600 hover:text-green-900 transition"
                                       title="Editar prueba">
                                        <i class="fas fa-edit text-xs sm:text-sm"></i>
                                    </a>
                                    <form action="{{ route('pruebas.destroy', $prueba) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition"
                                                onclick="return confirm('¿Está seguro de eliminar esta prueba?')"
                                                title="Eliminar prueba">
                                            <i class="fas fa-trash text-xs sm:text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Información adicional móvil -->
                                <div class="sm:hidden text-xs text-gray-500 mt-2 space-y-1">
                                    <div class="flex justify-between">
                                        <span>Fecha:</span>
                                        <span>{{ \Carbon\Carbon::parse($prueba->fecha_prueba)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Por:</span>
                                        <span class="truncate max-w-[100px]">{{ \Illuminate\Support\Str::limit($prueba->realizada_por, 12) }}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State -->
        @if($pruebas->isEmpty())
        <div class="text-center py-8 sm:py-12">
            <div class="bg-gray-50 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-flask text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay pruebas registradas</h3>
            <p class="text-gray-500 text-sm mb-6">Comienza registrando tu primera prueba de laboratorio</p>
            <a href="{{ route('pruebas.create') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-flex items-center text-sm font-medium">
                <i class="fas fa-plus mr-2"></i>Registrar primera prueba
            </a>
        </div>
        @endif

        <!-- Paginación (si existe) -->

    </div>
</div>

<style>
    @media (max-width: 640px) {
        .min-w-0 {
            min-width: 0;
        }
    }
    
    /* Mejorar la legibilidad en móviles */
    @media (max-width: 768px) {
        table {
            font-size: 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mejorar la experiencia en móviles
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('touchstart', function() {
                this.style.backgroundColor = '#f9fafb';
            });
            
            row.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.style.backgroundColor = '';
                }, 150);
            });
        });
        
        // Tooltips para iconos en móvil
        const actionIcons = document.querySelectorAll('td a, td button');
        actionIcons.forEach(icon => {
            icon.addEventListener('touchstart', function(e) {
                // Prevenir múltiples clics en móvil
                e.preventDefault();
                setTimeout(() => {
                    window.location.href = this.href || '#';
                }, 300);
            });
        });
    });
</script>
@endsection