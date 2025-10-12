@extends('layouts.app')

@section('title', 'Lote: ' . $lote->codigo_lote)

@section('breadcrumbs')
<span class="mx-2">/</span>
<a href="{{ route('granjas.index') }}" class="hover:text-gray-900">Granjas</a>
<span class="mx-2">/</span>
<a href="{{ route('granjas.show', $lote->granja) }}" class="hover:text-gray-900">{{ $lote->granja->nombre }}</a>
<span class="mx-2">/</span>
<span class="text-gray-500">{{ $lote->codigo_lote }}</span>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header del Lote -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $lote->codigo_lote }}</h3>
                <p class="text-gray-600 mt-1">
                    Granja: 
                    <a href="{{ route('granjas.show', $lote->granja) }}" class="text-blue-600 hover:text-blue-900 font-medium transition">
                        {{ $lote->granja->nombre }}
                    </a>
                    <span class="text-gray-400 mx-2">•</span>
                    <span class="text-gray-500">{{ $lote->granja->ubicacion }}</span>
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('lotes.edit', $lote) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('pruebas.create') }}?lote_id={{ $lote->id }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-flask mr-2"></i>Nueva Prueba
                </a>
                <a href="{{ route('granjas.show', $lote->granja) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-home mr-2"></i>Ver Granja
                </a>
            </div>
        </div>
    </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-egg text-blue-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-600">Número de Aves</p>
                            <p class="text-2xl font-bold text-blue-800">{{ number_format($lote->numero_aves) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-kiwi-bird text-green-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-green-600">Raza</p>
                            <p class="text-2xl font-bold text-green-800">{{ $lote->raza }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-purple-600">Fecha Ingreso</p>
                            <p class="text-2xl font-bold text-purple-800">{{ $lote->fecha_ingreso->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-orange-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-orange-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-orange-600">Total Pruebas</p>
                            <p class="text-2xl font-bold text-orange-800">{{ $lote->pruebas->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Lote -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Información del Lote</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estado:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $lote->estado == 'activo' ? 'bg-green-100 text-green-800' : 
                                   ($lote->estado == 'en_cuarentena' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($lote->estado) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Granja:</span>
                            <span class="font-medium">{{ $lote->granja->nombre }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ubicación:</span>
                            <span>{{ $lote->granja->ubicacion }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Responsable:</span>
                            <span>{{ $lote->granja->responsable }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Observaciones</h4>
                    <p class="text-gray-600">{{ $lote->observaciones ?? 'Sin observaciones' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pruebas del Lote -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h4 class="text-lg font-medium text-gray-900">Pruebas Realizadas</h4>
                <a href="{{ route('pruebas.create') }}?lote_id={{ $lote->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>Nueva Prueba
                </a>
            </div>
        </div>
        
        <div class="p-6">
            @if($lote->pruebas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo Prueba</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parámetro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Resultado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Realizada Por</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($lote->pruebas as $prueba)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ ucfirst($prueba->tipo_prueba) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $prueba->parametro }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $prueba->valor }} {{ $prueba->unidad_medida }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $prueba->resultado == 'normal' ? 'bg-green-100 text-green-800' : 
                                       ($prueba->resultado == 'anormal' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($prueba->resultado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $prueba->fecha_prueba->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $prueba->realizada_por }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('pruebas.show', $prueba) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pruebas.edit', $prueba) }}" class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-flask text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 text-lg">No hay pruebas registradas para este lote</p>
                <a href="{{ route('pruebas.create') }}?lote_id={{ $lote->id }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Registrar primera prueba
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection