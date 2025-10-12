@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Tarjeta 1 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-home text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Granjas</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalGranjas }}</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-list text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Lotes Activos</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $lotesActivos }}</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-flask text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Pruebas Realizadas</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPruebas }}</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 4 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Pruebas Anormales</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $pruebasAnormales }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Últimas Pruebas -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Últimas Pruebas Realizadas</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lote</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prueba</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Resultado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($ultimasPruebas as $prueba)
                                                <tr>
                                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $prueba->lote->codigo_lote }}</td>
                                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $prueba->parametro }}</td>
                                                    <td class="px-4 py-3">
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $prueba->resultado == 'normal' ? 'bg-green-100 text-green-800' :
                                ($prueba->resultado == 'anormal' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                            {{ ucfirst($prueba->resultado) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-900">
                                                        {{ \Carbon\Carbon::parse($prueba->fecha_prueba)->format('d/m/Y') }}
                                                    </td>
                                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Lotes Recientes</h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
<!-- Lotes Recientes - Mejorado -->
@foreach($lotesRecientes as $lote)
<div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
    <div>
        <a href="{{ route('lotes.show', $lote) }}" class="font-medium text-gray-900 hover:text-blue-600 transition">
            {{ $lote->codigo_lote }}
        </a>
        <p class="text-sm text-gray-600">
            <a href="{{ route('granjas.show', $lote->granja) }}" class="text-blue-600 hover:text-blue-900 transition">
                {{ $lote->granja->nombre }}
            </a>
            • {{ $lote->raza }} • {{ number_format($lote->numero_aves) }} aves
        </p>
    </div>
    <div class="flex space-x-2">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
            {{ $lote->estado == 'activo' ? 'bg-green-100 text-green-800' : 
               ($lote->estado == 'en_cuarentena' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
            {{ ucfirst($lote->estado) }}
        </span>
        <a href="{{ route('pruebas.create') }}?lote_id={{ $lote->id }}" 
           class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded hover:bg-purple-200 transition"
           title="Registrar prueba">
            <i class="fas fa-flask"></i>
        </a>
    </div>
</div>
@endforeach
        </div>
        
        @if($lotesRecientes->isEmpty())
        <div class="text-center py-4">
            <p class="text-gray-500">No hay lotes registrados</p>
            <a href="{{ route('lotes.create') }}" class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Crear primer lote
            </a>
        </div>
        @else
        <div class="mt-4 text-center">
            <a href="{{ route('lotes.index') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                Ver todos los lotes →
            </a>
        </div>
        @endif
    </div>
</div>



        <!-- Resumen por Granja -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Resumen por Granja</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($granjas as $granja)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div>
                                <a href="{{ route('granjas.show', $granja) }}"
                                    class="font-medium text-gray-900 hover:text-blue-600">
                                    {{ $granja->nombre }}
                                </a>
                                <p class="text-sm text-gray-600">{{ $granja->lotes_count }} lotes activos</p>
                            </div>
                            <div class="flex space-x-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $granja->ubicacion }}
                                </span>
                                <a href="{{ route('lotes.create') }}?granja_id={{ $granja->id }}"
                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded hover:bg-green-200"
                                    title="Crear nuevo lote">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection