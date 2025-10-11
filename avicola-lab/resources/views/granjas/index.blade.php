@extends('layouts.app')

@section('title', 'Gestión de Granjas')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Lista de Granjas</h3>
            <a href="{{ route('granjas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Nueva Granja
            </a>
        </div>
    </div>
    
    <!-- Mensajes de éxito/error -->
    @if(session('success'))
    <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($granjas as $granja)
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-home text-blue-600"></i>
                        </div>
                        <h4 class="ml-3 text-lg font-semibold text-gray-900">{{ $granja->nombre }}</h4>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ $granja->lotes_count }} lotes
                    </span>
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
                        <span>{{ $granja->telefono ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                        <span class="truncate">{{ $granja->email ?? 'N/A' }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500">{{ Str::limit($granja->descripcion, 100) }}</p>
                </div>
                
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('granjas.show', $granja) }}" class="flex-1 bg-blue-50 text-blue-700 py-2 px-3 rounded text-sm hover:bg-blue-100 transition text-center">
                        <i class="fas fa-eye mr-1"></i>Ver
                    </a>
                    <a href="{{ route('granjas.edit', $granja) }}" class="flex-1 bg-green-50 text-green-700 py-2 px-3 rounded text-sm hover:bg-green-100 transition text-center">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </a>
                    <form action="{{ route('granjas.destroy', $granja) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 text-red-700 py-2 px-3 rounded text-sm hover:bg-red-100 transition" 
                                onclick="return confirm('¿Está seguro de eliminar esta granja?')">
                            <i class="fas fa-trash mr-1"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        @if($granjas->isEmpty())
        <div class="text-center py-8">
            <i class="fas fa-home text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-500 text-lg">No hay granjas registradas</p>
            <a href="{{ route('granjas.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Crear primera granja
            </a>
        </div>
        @endif
    </div>
</div>
@endsection