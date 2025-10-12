@extends('layouts.app')

@section('title', 'Prueba: ' . $prueba->parametro)

@section('breadcrumbs')
<span class="mx-2">/</span>
<a href="{{ route('granjas.index') }}" class="hover:text-gray-900">Granjas</a>
<span class="mx-2">/</span>
<a href="{{ route('granjas.show', $prueba->lote->granja) }}" class="hover:text-gray-900">{{ $prueba->lote->granja->nombre }}</a>
<span class="mx-2">/</span>
<a href="{{ route('lotes.show', $prueba->lote) }}" class="hover:text-gray-900">{{ $prueba->lote->codigo_lote }}</a>
<span class="mx-2">/</span>
<span class="text-gray-500">{{ $prueba->parametro }}</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header de la Prueba -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $prueba->parametro }}</h3>
                    <p class="text-gray-600 mt-1">{{ ucfirst($prueba->tipo_prueba) }} - {{ $prueba->lote->codigo_lote }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('pruebas.edit', $prueba) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    <a href="{{ route('lotes.show', $prueba->lote) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Ver Lote
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-flask text-blue-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-600">Tipo de Prueba</p>
                            <p class="text-lg font-bold text-blue-800">{{ ucfirst($prueba->tipo_prueba) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-green-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-green-600">Valor</p>
                            <p class="text-lg font-bold text-green-800">{{ $prueba->valor }} {{ $prueba->unidad_medida }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-purple-600">Fecha Prueba</p>
                            <p class="text-lg font-bold text-purple-800">{{ $prueba->fecha_prueba->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Detallada -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Información de la Prueba</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Resultado:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $prueba->resultado == 'normal' ? 'bg-green-100 text-green-800' : 
                                   ($prueba->resultado == 'anormal' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($prueba->resultado) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Realizada Por:</span>
                            <span class="font-medium">{{ $prueba->realizada_por }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fecha de Registro:</span>
                            <span>{{ $prueba->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Última Actualización:</span>
                            <span>{{ $prueba->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

<!-- Información del Lote - Mejorada -->
<div>
    <h4 class="text-lg font-medium text-gray-900 mb-4">Información del Lote</h4>
    <div class="space-y-3">
        <div class="flex justify-between">
            <span class="text-gray-600">Código Lote:</span>
            <a href="{{ route('lotes.show', $prueba->lote) }}" class="text-blue-600 hover:text-blue-900 font-medium transition">
                {{ $prueba->lote->codigo_lote }}
            </a>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Granja:</span>
            <a href="{{ route('granjas.show', $prueba->lote->granja) }}" class="text-blue-600 hover:text-blue-900 transition">
                {{ $prueba->lote->granja->nombre }}
            </a>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Raza:</span>
            <span>{{ $prueba->lote->raza }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">N° Aves:</span>
            <span>{{ number_format($prueba->lote->numero_aves) }}</span>
        </div>
    </div>
</div>
            </div>

            <!-- Observaciones -->
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Observaciones</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $prueba->observaciones ?? 'Sin observaciones' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Adicionales -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-lg font-medium text-gray-900">Acciones</h4>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('pruebas.edit', $prueba) }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition flex items-center">
                    <i class="fas fa-edit mr-2"></i>Editar Prueba
                </a>
                <a href="{{ route('lotes.show', $prueba->lote) }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-list mr-2"></i>Ver Lote Completo
                </a>
                <form action="{{ route('pruebas.destroy', $prueba) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition flex items-center" 
                            onclick="return confirm('¿Está seguro de eliminar esta prueba?')">
                        <i class="fas fa-trash mr-2"></i>Eliminar Prueba
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection