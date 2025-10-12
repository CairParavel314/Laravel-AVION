@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Grid de tarjetas responsive -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
    <!-- Tarjeta 1 -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-home text-blue-600 text-lg sm:text-xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="text-xs sm:text-sm font-medium text-gray-600">Total Granjas</h3>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $totalGranjas }}</p>
            </div>
        </div>
    </div>

    <!-- Tarjeta 2 -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-green-100 rounded-lg">
                <i class="fas fa-list text-green-600 text-lg sm:text-xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="text-xs sm:text-sm font-medium text-gray-600">Lotes Activos</h3>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $lotesActivos }}</p>
            </div>
        </div>
    </div>

    <!-- Tarjeta 3 -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-flask text-purple-600 text-lg sm:text-xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="text-xs sm:text-sm font-medium text-gray-600">Pruebas Realizadas</h3>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $totalPruebas }}</p>
            </div>
        </div>
    </div>

    <!-- Tarjeta 4 -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-red-100 rounded-lg">
                <i class="fas fa-exclamation-triangle text-red-600 text-lg sm:text-xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="text-xs sm:text-sm font-medium text-gray-600">Pruebas Anormales</h3>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $pruebasAnormales }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos y Tablas -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
    <!-- Últimas Pruebas -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Últimas Pruebas</h3>
        </div>
        <div class="p-3 sm:p-6">
            <div class="overflow-x-auto -mx-2 sm:mx-0">
                <div class="min-w-full inline-block align-middle">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lote</th>
                                <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prueba</th>
                                <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Resultado</th>
                                <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($ultimasPruebas as $prueba)
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 sm:px-4 py-2">
                                    <a href="{{ route('lotes.show', $prueba->lote) }}" 
                                       class="text-blue-600 hover:text-blue-900 font-medium text-xs sm:text-sm block">
                                        {{ $prueba->lote->codigo_lote }}
                                    </a>
                                    <a href="{{ route('granjas.show', $prueba->lote->granja) }}" 
                                       class="text-xs text-gray-500 hover:text-gray-700 block mt-1">
                                        {{ \Illuminate\Support\Str::limit($prueba->lote->granja->nombre, 15) }}
                                    </a>
                                </td>
                                <td class="px-2 sm:px-4 py-2">
                                    <a href="{{ route('pruebas.show', $prueba) }}" 
                                       class="text-purple-600 hover:text-purple-900 font-medium text-xs sm:text-sm block">
                                        {{ \Illuminate\Support\Str::limit($prueba->parametro, 12) }}
                                    </a>
                                    <span class="text-xs text-gray-500 block mt-1">
                                        {{ \Illuminate\Support\Str::limit($prueba->tipo_prueba, 8) }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-4 py-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $prueba->resultado == 'normal' ? 'bg-green-100 text-green-800' :
                                           ($prueba->resultado == 'anormal' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ substr(ucfirst($prueba->resultado), 0, 1) }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-4 py-2 text-xs sm:text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($prueba->fecha_prueba)->format('d/m/Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($ultimasPruebas->count() > 0)
            <div class="mt-4 text-center">
                <a href="{{ route('pruebas.index') }}" class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm font-medium">
                    Ver todas →
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Resumen por Granja -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Resumen por Granja</h3>
        </div>
        <div class="p-3 sm:p-6">
            <div class="space-y-3">
                @foreach($granjas as $granja)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('granjas.show', $granja) }}" class="font-medium text-gray-900 hover:text-blue-600 text-sm sm:text-base truncate block">
                            {{ $granja->nombre }}
                        </a>
                        <p class="text-xs text-gray-600 truncate">{{ $granja->lotes_count }} lotes activos</p>
                    </div>
                    <div class="flex space-x-2 flex-shrink-0 ml-2">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded truncate max-w-[80px] sm:max-w-none">
                            {{ \Illuminate\Support\Str::limit($granja->ubicacion, 8) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Lotes Recientes -->
<div class="mt-6 bg-white rounded-lg shadow">
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <h3 class="text-base sm:text-lg font-medium text-gray-900">Lotes Recientes</h3>
    </div>
    <div class="p-3 sm:p-6">
        <div class="space-y-3">
            @foreach($lotesRecientes as $lote)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="min-w-0 flex-1">
                    <a href="{{ route('lotes.show', $lote) }}" class="font-medium text-gray-900 hover:text-blue-600 text-sm sm:text-base truncate block">
                        {{ $lote->codigo_lote }}
                    </a>
                    <p class="text-xs text-gray-600 truncate">
                        <a href="{{ route('granjas.show', $lote->granja) }}" class="text-blue-600 hover:text-blue-900">
                            {{ \Illuminate\Support\Str::limit($lote->granja->nombre, 20) }}
                        </a>
                        • {{ \Illuminate\Support\Str::limit($lote->raza, 12) }}
                    </p>
                </div>
                <div class="flex space-x-2 flex-shrink-0 ml-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $lote->estado == 'activo' ? 'bg-green-100 text-green-800' : 
                           ($lote->estado == 'en_cuarentena' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ substr(ucfirst($lote->estado), 0, 1) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($lotesRecientes->count() > 0)
        <div class="mt-4 text-center">
            <a href="{{ route('lotes.index') }}" class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm font-medium">
                Ver todos los lotes →
            </a>
        </div>
        @endif
    </div>
</div>
@endsection