@extends('layouts.app')

@section('title', 'Gestión de Lotes')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Lista de Lotes</h3>
            <a href="{{ route('lotes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Nuevo Lote
            </a>
        </div>
    </div>
    
    <div class="p-6">
        <div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Granja</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Raza</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Aves</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Ingreso</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pruebas</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach($lotes as $lote)
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                <a href="{{ route('lotes.show', $lote) }}" class="text-blue-600 hover:text-blue-900">
                    {{ $lote->codigo_lote }}
                </a>
            </td>
<td class="px-6 py-4 text-sm text-gray-900">
    <a href="{{ route('granjas.show', $lote->granja) }}" class="text-blue-600 hover:text-blue-900 font-medium transition">
        {{ $lote->granja->nombre }}
    </a>
    <p class="text-xs text-gray-500 mt-1">{{ $lote->granja->ubicacion }}</p>
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
                <a href="{{ route('lotes.show', $lote) }}" class="text-purple-600 hover:text-purple-900">
                    {{ $lote->pruebas->count() }}
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
                    <form action="{{ route('lotes.destroy', $lote) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                onclick="return confirm('¿Está seguro de eliminar este lote?')"
                                title="Eliminar lote">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
        </div>
    </div>
</div>
@endsection