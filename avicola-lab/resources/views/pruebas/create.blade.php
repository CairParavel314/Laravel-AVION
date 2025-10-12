@extends('layouts.app')

@section('title', 'Registrar Nueva Prueba')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Registrar Nueva Prueba</h3>
        </div>
        
        <form action="{{ route('pruebas.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
                <!-- Selección de Lote -->
                <div>
                    <label for="lote_id" class="block text-sm font-medium text-gray-700">Lote *</label>
                    <select name="lote_id" id="lote_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccione un lote</option>
                        @foreach($lotes as $lote)
                            <option value="{{ $lote->id }}" 
                                {{ (old('lote_id') == $lote->id || request('lote_id') == $lote->id) ? 'selected' : '' }}>
                                {{ $lote->codigo_lote }} - {{ $lote->granja->nombre }} ({{ $lote->raza }})
                            </option>
                        @endforeach
                    </select>
                    @error('lote_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipo de Prueba -->
                    <div>
                        <label for="tipo_prueba" class="block text-sm font-medium text-gray-700">Tipo de Prueba *</label>
                        <select name="tipo_prueba" id="tipo_prueba" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione tipo</option>
                            <option value="alimento" {{ old('tipo_prueba') == 'alimento' ? 'selected' : '' }}>Alimento</option>
                            <option value="laboratorio" {{ old('tipo_prueba') == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                            <option value="sanidad" {{ old('tipo_prueba') == 'sanidad' ? 'selected' : '' }}>Sanidad</option>
                            <option value="ambiental" {{ old('tipo_prueba') == 'ambiental' ? 'selected' : '' }}>Ambiental</option>
                            <option value="calidad" {{ old('tipo_prueba') == 'calidad' ? 'selected' : '' }}>Calidad</option>
                        </select>
                        @error('tipo_prueba')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Prueba -->
                    <div>
                        <label for="fecha_prueba" class="block text-sm font-medium text-gray-700">Fecha de Prueba *</label>
                        <input type="date" name="fecha_prueba" id="fecha_prueba" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('fecha_prueba') }}">
                        @error('fecha_prueba')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Parámetro -->
                    <div>
                        <label for="parametro" class="block text-sm font-medium text-gray-700">Parámetro *</label>
                        <input type="text" name="parametro" id="parametro" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('parametro') }}"
                               placeholder="Ej: Proteína, Salmonella, pH...">
                        @error('parametro')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Realizada Por -->
                    <div>
                        <label for="realizada_por" class="block text-sm font-medium text-gray-700">Realizada Por *</label>
                        <input type="text" name="realizada_por" id="realizada_por" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('realizada_por') }}"
                               placeholder="Ej: Dr. Pérez, Lab. Central...">
                        @error('realizada_por')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Valor -->
                    <div>
                        <label for="valor" class="block text-sm font-medium text-gray-700">Valor *</label>
                        <input type="number" name="valor" id="valor" required step="0.01"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('valor') }}"
                               placeholder="Ej: 18.5">
                        @error('valor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unidad de Medida -->
                    <div>
                        <label for="unidad_medida" class="block text-sm font-medium text-gray-700">Unidad de Medida *</label>
                        <input type="text" name="unidad_medida" id="unidad_medida" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('unidad_medida') }}"
                               placeholder="Ej: %, UFC/g, mg/L...">
                        @error('unidad_medida')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Resultado -->
                    <div>
                        <label for="resultado" class="block text-sm font-medium text-gray-700">Resultado *</label>
                        <select name="resultado" id="resultado" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione resultado</option>
                            <option value="normal" {{ old('resultado') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="anormal" {{ old('resultado') == 'anormal' ? 'selected' : '' }}>Anormal</option>
                            <option value="critico" {{ old('resultado') == 'critico' ? 'selected' : '' }}>Crítico</option>
                        </select>
                        @error('resultado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" rows="4"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Observaciones sobre la prueba...">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
                <a href="{{ url()->previous() }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-flask mr-2"></i>Registrar Prueba
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Establecer fecha actual como valor por defecto
        const fechaInput = document.getElementById('fecha_prueba');
        if (!fechaInput.value) {
            const today = new Date().toISOString().split('T')[0];
            fechaInput.value = today;
        }

        // Pre-seleccionar lote si viene por URL
        const urlParams = new URLSearchParams(window.location.search);
        const loteId = urlParams.get('lote_id');
        const loteSelect = document.getElementById('lote_id');
        
        if (loteId && loteSelect) {
            loteSelect.value = loteId;
            // Deshabilitar el select para evitar cambios
            loteSelect.disabled = true;
            
            // Agregar mensaje informativo
            const infoDiv = document.createElement('div');
            infoDiv.className = 'mt-2 text-sm text-blue-600';
            infoDiv.innerHTML = '<i class="fas fa-info-circle mr-1"></i> Lote pre-seleccionado desde la vista anterior';
            loteSelect.parentNode.appendChild(infoDiv);
        }

        // Auto-completar "realizada_por" si está vacío
        const realizadaPorInput = document.getElementById('realizada_por');
        if (!realizadaPorInput.value) {
            realizadaPorInput.value = 'Lab. Central';
        }

        // Cambiar placeholder de unidad de medida según el tipo de prueba
        const tipoPruebaSelect = document.getElementById('tipo_prueba');
        const unidadMedidaInput = document.getElementById('unidad_medida');
        
        tipoPruebaSelect.addEventListener('change', function() {
            const placeholders = {
                'alimento': '%, mg/kg, kcal',
                'laboratorio': 'UFC/g, %, mg/L',
                'sanidad': 'UFC/g, positivo/negativo',
                'ambiental': '°C, %, ppm',
                'calidad': '%, puntos, escala'
            };
            
            unidadMedidaInput.placeholder = placeholders[this.value] || 'Unidad de medida';
        });
    });
</script>
@endsection