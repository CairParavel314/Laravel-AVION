@extends('layouts.app')

@section('title', 'Crear Nuevo Lote')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Crear Nuevo Lote</h3>
        </div>
        
        <form action="{{ route('lotes.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
                <!-- Selección de Granja -->
                <div>
                    <label for="granja_id" class="block text-sm font-medium text-gray-700">Granja *</label>
                    <select name="granja_id" id="granja_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccione una granja</option>
                        @foreach($granjas as $granja)
                            <option value="{{ $granja->id }}" {{ old('granja_id') == $granja->id ? 'selected' : '' }}>
                                {{ $granja->nombre }} - {{ $granja->ubicacion }}
                            </option>
                        @endforeach
                    </select>
                    @error('granja_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Código del Lote -->
                <div>
                    <label for="codigo_lote" class="block text-sm font-medium text-gray-700">Código del Lote *</label>
                    <input type="text" name="codigo_lote" id="codigo_lote" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('codigo_lote') }}"
                           placeholder="Ej: LOTE-001-2024">
                    @error('codigo_lote')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Fecha de Ingreso -->
                    <div>
                        <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso *</label>
                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('fecha_ingreso') }}">
                        @error('fecha_ingreso')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número de Aves -->
                    <div>
                        <label for="numero_aves" class="block text-sm font-medium text-gray-700">Número de Aves *</label>
                        <input type="number" name="numero_aves" id="numero_aves" required min="1"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('numero_aves') }}"
                               placeholder="Ej: 5000">
                        @error('numero_aves')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Raza -->
                    <div>
                        <label for="raza" class="block text-sm font-medium text-gray-700">Raza *</label>
                        <select name="raza" id="raza" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione una raza</option>
                            <option value="Lohmann Brown" {{ old('raza') == 'Lohmann Brown' ? 'selected' : '' }}>Lohmann Brown</option>
                            <option value="Hy-Line Brown" {{ old('raza') == 'Hy-Line Brown' ? 'selected' : '' }}>Hy-Line Brown</option>
                            <option value="Isa Brown" {{ old('raza') == 'Isa Brown' ? 'selected' : '' }}>Isa Brown</option>
                            <option value="Babcock" {{ old('raza') == 'Babcock' ? 'selected' : '' }}>Babcock</option>
                            <option value="Hubbard" {{ old('raza') == 'Hubbard' ? 'selected' : '' }}>Hubbard</option>
                            <option value="Cobb" {{ old('raza') == 'Cobb' ? 'selected' : '' }}>Cobb</option>
                        </select>
                        @error('raza')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado *</label>
                        <select name="estado" id="estado" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="en_cuarentena" {{ old('estado') == 'en_cuarentena' ? 'selected' : '' }}>En Cuarentena</option>
                            <option value="finalizado" {{ old('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" rows="4"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Observaciones sobre el lote...">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
                <a href="{{ route('lotes.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar Lote
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Establecer fecha actual como valor por defecto
        const fechaInput = document.getElementById('fecha_ingreso');
        if (!fechaInput.value) {
            const today = new Date().toISOString().split('T')[0];
            fechaInput.value = today;
        }

        // Generar código de lote automáticamente si está vacío
        const codigoInput = document.getElementById('codigo_lote');
        const granjaSelect = document.getElementById('granja_id');
        
        granjaSelect.addEventListener('change', function() {
            if (!codigoInput.value && this.value) {
                const timestamp = new Date().getTime().toString().slice(-4);
                codigoInput.value = `LOTE-${this.value}-${timestamp}`;
            }
        });
    });
</script>
@endsection