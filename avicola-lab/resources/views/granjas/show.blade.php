@extends('layouts.app')

@section('title', $granja->nombre)

@section('breadcrumbs')
<span class="mx-2">/</span>
<a href="{{ route('granjas.index') }}" class="hover:text-gray-900">Granjas</a>
<span class="mx-2">/</span>
<span class="text-gray-500">{{ $granja->nombre }}</span>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header de la granja -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $granja->nombre }}</h3>
                        <p class="text-gray-600 mt-1">{{ $granja->ubicacion }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('granjas.edit', $granja) }}"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-edit mr-2"></i>Editar
                        </a>
                        <a href="{{ route('granjas.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-blue-600">Total Lotes</p>
                                <p class="text-2xl font-bold text-blue-800">{{ $estadisticas['total_lotes'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-green-600">Lotes Activos</p>
                                <p class="text-2xl font-bold text-green-800">{{ $estadisticas['lotes_activos'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-flag-checkered text-gray-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Lotes Finalizados</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['lotes_finalizados'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-flask text-purple-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm text-purple-600">Total Pruebas</p>
                                <p class="text-2xl font-bold text-purple-800">{{ $estadisticas['total_pruebas'] }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="bg-orange-50 rounded-lg p-4 flex items-center justify-center">
                        <a href="{{ route('lotes.create') }}?granja_id={{ $granja->id }}"
                            class="text-orange-600 hover:text-orange-800 text-center">
                            <i class="fas fa-plus-circle text-3xl mb-2"></i>
                            <p class="text-sm font-medium">Nuevo Lote</p>
                        </a>
                    </div>

                </div>

                <!-- Información de contacto -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Información de Contacto</h4>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-user text-gray-400 w-5"></i>
                                <span class="ml-3 text-gray-600">Responsable: {{ $granja->responsable }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 w-5"></i>
                                <span class="ml-3 text-gray-600">Teléfono: {{ $granja->telefono ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 w-5"></i>
                                <span class="ml-3 text-gray-600">Email: {{ $granja->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Descripción</h4>
                        <p class="text-gray-600">{{ $granja->descripcion ?? 'Sin descripción' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lotes de la granja -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h4 class="text-lg font-medium text-gray-900">Lotes de esta Granja</h4>
            <a href="{{ route('lotes.create') }}?granja_id={{ $granja->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Nuevo Lote
            </a>
        </div>
    </div>
    
    <div class="p-6">
        @if($granja->lotes->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Raza</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Aves</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Ingreso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pruebas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($granja->lotes as $lote)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <a href="{{ route('lotes.show', $lote) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $lote->codigo_lote }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $lote->raza }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ number_format($lote->numero_aves) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $lote->estado == 'activo' ? 'bg-green-100 text-green-800' : 
                                   ($lote->estado == 'en_cuarentena' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($lote->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($lote->fecha_ingreso)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <a href="{{ route('lotes.show', $lote) }}#pruebas" class="text-purple-600 hover:text-purple-900">
                                {{ $lote->pruebas->count() }} pruebas
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('lotes.show', $lote) }}" class="text-blue-600 hover:text-blue-900" title="Ver lote">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('lotes.edit', $lote) }}" class="text-green-600 hover:text-green-900" title="Editar lote">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('pruebas.create') }}?lote_id={{ $lote->id }}" class="text-purple-600 hover:text-purple-900" title="Nueva prueba">
                                    <i class="fas fa-flask"></i>
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
            <i class="fas fa-list text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-500 text-lg">No hay lotes registrados para esta granja</p>
            <a href="{{ route('lotes.create') }}?granja_id={{ $granja->id }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Crear primer lote
            </a>
        </div>
        @endif
    </div>
</div>
    </div>
@endsection