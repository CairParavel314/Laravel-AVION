@extends('layouts.app')

@section('title', 'Gestión de Granjas')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Lista de Granjas</h3>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Nueva Granja
            </button>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($granjas as $granja)
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-home text-blue-600"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-semibold text-gray-900">{{ $granja->nombre }}</h4>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                        <span>{{ $granja->ubicacion }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2 text-gray-400"></i>
                        <span>{{ $granja->responsable }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone mr-2 text-gray-400"></i>
                        <span>{{ $granja->telefono }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500">{{ $granja->descripcion }}</p>
                </div>
                
                <div class="mt-4 flex space-x-2">
                    <button class="flex-1 bg-blue-50 text-blue-700 py-2 px-3 rounded text-sm hover:bg-blue-100 transition">
                        <i class="fas fa-eye mr-1"></i>Ver
                    </button>
                    <button class="flex-1 bg-green-50 text-green-700 py-2 px-3 rounded text-sm hover:bg-green-100 transition">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection