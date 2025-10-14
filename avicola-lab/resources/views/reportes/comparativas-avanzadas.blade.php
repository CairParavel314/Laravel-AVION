@extends('layouts.app')

@section('title', 'Comparativas Avanzadas - Reportes')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start space-y-4 lg:space-y-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Comparativas Avanzadas</h1>
                    <p class="text-gray-600 mt-1">Análisis comparativo entre granjas o lotes específicos</p>
                </div>
            </div>
        </div>
        
        <!-- Filtros Avanzados -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('reportes.comparativas-avanzadas') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- Rango de Tiempo -->
                    <div>
                        <label for="semanas" class="block text-sm font-medium text-gray-700 mb-1">Rango</label>
                        <select name="semanas" id="semanas" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @foreach([4, 8, 12, 26] as $numSemanas)
                            <option value="{{ $numSemanas }}" {{ $semanas == $numSemanas ? 'selected' : '' }}>
                                {{ $numSemanas }} semanas
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipo de Comparación -->
                    <div>
                        <label for="tipo_comparacion" class="block text-sm font-medium text-gray-700 mb-1">Comparar</label>
                        <select name="tipo_comparacion" id="tipo_comparacion" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="granjas" {{ $tipoComparacion == 'granjas' ? 'selected' : '' }}>Granjas</option>
                            <option value="lotes" {{ $tipoComparacion == 'lotes' ? 'selected' : '' }}>Lotes</option>
                        </select>
                    </div>

                    <!-- Filtro Tipo de Prueba -->
                    <div>
                        <label for="tipo_prueba" class="block text-sm font-medium text-gray-700 mb-1">Tipo Prueba</label>
                        <select name="tipo_prueba" id="tipo_prueba" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="todos" {{ $tipoPrueba == 'todos' ? 'selected' : '' }}>Todos los tipos</option>
                            @foreach($tiposPruebaUnicos as $tipo)
                            <option value="{{ $tipo }}" {{ $tipoPrueba == $tipo ? 'selected' : '' }}>
                                {{ ucfirst($tipo) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro Parámetro -->
                    <div>
                        <label for="parametro" class="block text-sm font-medium text-gray-700 mb-1">Parámetro</label>
                        <select name="parametro" id="parametro" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="todos" {{ $parametro == 'todos' ? 'selected' : '' }}>Todos los parámetros</option>
                            @foreach($parametrosUnicos as $param)
                            <option value="{{ $param }}" {{ $parametro == $param ? 'selected' : '' }}>
                                {{ $param }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Selectores de Elementos a Comparar -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-200">
                    <!-- Elemento 1 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span id="label-elemento1">{{ $tipoComparacion == 'granjas' ? 'Granja 1' : 'Lote 1' }}</span>
                        </label>
                        <select name="elemento1_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccionar {{ $tipoComparacion == 'granjas' ? 'granja' : 'lote' }}</option>
                            @if($tipoComparacion == 'granjas')
                                @foreach($granjas as $granja)
                                <option value="{{ $granja->id }}" {{ $elemento1Id == $granja->id ? 'selected' : '' }}>
                                    {{ $granja->nombre }}
                                </option>
                                @endforeach
                            @else
                                @foreach($lotes as $lote)
                                <option value="{{ $lote->id }}" {{ $elemento1Id == $lote->id ? 'selected' : '' }}>
                                    {{ $lote->codigo_lote }} - {{ $lote->granja->nombre }}
                                </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Elemento 2 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span id="label-elemento2">{{ $tipoComparacion == 'granjas' ? 'Granja 2' : 'Lote 2' }}</span>
                        </label>
                        <select name="elemento2_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccionar {{ $tipoComparacion == 'granjas' ? 'granja' : 'lote' }}</option>
                            @if($tipoComparacion == 'granjas')
                                @foreach($granjas as $granja)
                                <option value="{{ $granja->id }}" {{ $elemento2Id == $granja->id ? 'selected' : '' }}>
                                    {{ $granja->nombre }}
                                </option>
                                @endforeach
                            @else
                                @foreach($lotes as $lote)
                                <option value="{{ $lote->id }}" {{ $elemento2Id == $lote->id ? 'selected' : '' }}>
                                    {{ $lote->codigo_lote }} - {{ $lote->granja->nombre }}
                                </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center text-sm">
                        <i class="fas fa-chart-line mr-2"></i>Generar Comparativa
                    </button>
                    <a href="{{ route('reportes.comparativas-avanzadas') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition flex items-center text-sm">
                        <i class="fas fa-redo mr-2"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($datosComparativa)
    <!-- Resumen de la Comparativa -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tarjeta Elemento 1 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    @if($tipoComparacion == 'granjas')
                        {{ $datosComparativa['elemento1']['elemento']->nombre }}
                    @else
                        {{ $datosComparativa['elemento1']['elemento']->codigo_lote }}
                        <span class="text-sm text-gray-600 block">
                            {{ $datosComparativa['elemento1']['elemento']->granja->nombre }}
                        </span>
                    @endif
                </h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    Elemento 1
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $datosComparativa['elemento1']['total_pruebas'] }}</p>
                    <p class="text-xs text-gray-600">Total Pruebas</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $datosComparativa['elemento1']['tasa_normalidad'] }}%</p>
                    <p class="text-xs text-gray-600">Tasa Normalidad</p>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pruebas Normales:</span>
                    <span class="font-medium">{{ $datosComparativa['elemento1']['pruebas_normales'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pruebas Anormales:</span>
                    <span class="font-medium text-yellow-600">{{ $datosComparativa['elemento1']['pruebas_anormales'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pruebas Críticas:</span>
                    <span class="font-medium text-red-600">{{ $datosComparativa['elemento1']['pruebas_criticas'] }}</span>
                </div>
            </div>
        </div>

        <!-- Tarjeta Elemento 2 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    @if($tipoComparacion == 'granjas')
                        {{ $datosComparativa['elemento2']['elemento']->nombre }}
                    @else
                        {{ $datosComparativa['elemento2']['elemento']->codigo_lote }}
                        <span class="text-sm text-gray-600 block">
                            {{ $datosComparativa['elemento2']['elemento']->granja->nombre }}
                        </span>
                    @endif
                </h3>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    Elemento 2
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $datosComparativa['elemento2']['total_pruebas'] }}</p>
                    <p class="text-xs text-gray-600">Total Pruebas</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $datosComparativa['elemento2']['tasa_normalidad'] }}%</p>
                    <p class="text-xs text-gray-600">Tasa Normalidad</p>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pruebas Normales:</span>
                    <span class="font-medium">{{ $datosComparativa['elemento2']['pruebas_normales'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pruebas Anormales:</span>
                    <span class="font-medium text-yellow-600">{{ $datosComparativa['elemento2']['pruebas_anormales'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pruebas Críticas:</span>
                    <span class="font-medium text-red-600">{{ $datosComparativa['elemento2']['pruebas_criticas'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Histograma Comparativo -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Histograma Comparativo - Tasa de Normalidad</h3>
            <p class="text-sm text-gray-600 mt-1">Evolución semanal comparativa de la tasa de normalidad</p>
        </div>
        <div class="p-6">
            <div class="h-96">
                <canvas id="histogramaComparativoChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Estadísticas Comparativas -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Análisis Comparativo</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">
                        {{ $datosComparativa['estadisticas']['diferencia_total_pruebas'] }}
                    </p>
                    <p class="text-sm text-blue-800">Diferencia en Total Pruebas</p>
                    <p class="text-xs text-gray-600 mt-1">
                        @if($datosComparativa['estadisticas']['diferencia_total_pruebas'] > 0)
                            Elemento 1 tiene más pruebas
                        @elseif($datosComparativa['estadisticas']['diferencia_total_pruebas'] < 0)
                            Elemento 2 tiene más pruebas
                        @else
                            Misma cantidad de pruebas
                        @endif
                    </p>
                </div>

                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">
                        {{ abs($datosComparativa['estadisticas']['diferencia_tasa_normalidad']) }}%
                    </p>
                    <p class="text-sm text-green-800">Diferencia en Tasa Normalidad</p>
                    <p class="text-xs text-gray-600 mt-1">
                        @if($datosComparativa['estadisticas']['diferencia_tasa_normalidad'] > 0)
                            Elemento 1 tiene mejor tasa
                        @elseif($datosComparativa['estadisticas']['diferencia_tasa_normalidad'] < 0)
                            Elemento 2 tiene mejor tasa
                        @else
                            Misma tasa de normalidad
                        @endif
                    </p>
                </div>

                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">
                        {{ $datosComparativa['estadisticas']['ratio_pruebas'] }}:1
                    </p>
                    <p class="text-sm text-purple-800">Ratio de Pruebas</p>
                    <p class="text-xs text-gray-600 mt-1">
                        Elemento 1 : Elemento 2
                    </p>
                </div>

                <div class="text-center p-4 bg-orange-50 rounded-lg">
                    <p class="text-2xl font-bold text-orange-600">
                        @if($datosComparativa['estadisticas']['mejor_tasa_normalidad'] == 'elemento1')
                            Elemento 1
                        @else
                            Elemento 2
                        @endif
                    </p>
                    <p class="text-sm text-orange-800">Mejor Desempeño</p>
                    <p class="text-xs text-gray-600 mt-1">
                        Mayor tasa de normalidad
                    </p>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Estado cuando no hay comparativa -->
    <div class="bg-white rounded-lg shadow text-center py-12">
        <i class="fas fa-chart-line text-gray-400 text-4xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Selecciona elementos para comparar</h3>
        <p class="text-gray-500">Elige dos {{ $tipoComparacion == 'granjas' ? 'granjas' : 'lotes' }} y genera una comparativa detallada.</p>
    </div>
    @endif
</div>

<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar labels cuando cambia el tipo de comparación
    const tipoComparacion = document.getElementById('tipo_comparacion');
    const labelElemento1 = document.getElementById('label-elemento1');
    const labelElemento2 = document.getElementById('label-elemento2');

    tipoComparacion.addEventListener('change', function() {
        if (this.value === 'granjas') {
            labelElemento1.textContent = 'Granja 1';
            labelElemento2.textContent = 'Granja 2';
        } else {
            labelElemento1.textContent = 'Lote 1';
            labelElemento2.textContent = 'Lote 2';
        }
    });

    @if($datosComparativa)
    // Histograma Comparativo
    const histogramaCtx = document.getElementById('histogramaComparativoChart').getContext('2d');
    const histogramaChart = new Chart(histogramaCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(collect($datosComparativa['histograma'])->pluck('semana')) !!},
            datasets: [
                {
                    label: '{{ $tipoComparacion == "granjas" ? $datosComparativa["elemento1"]["elemento"]->nombre : $datosComparativa["elemento1"]["elemento"]->codigo_lote }} - Tasa Normalidad',
                    data: {!! json_encode(collect($datosComparativa['histograma'])->pluck('elemento1_tasa')) !!},
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: '{{ $tipoComparacion == "granjas" ? $datosComparativa["elemento2"]["elemento"]->nombre : $datosComparativa["elemento2"]["elemento"]->codigo_lote }} - Tasa Normalidad',
                    data: {!! json_encode(collect($datosComparativa['histograma'])->pluck('elemento2_tasa')) !!},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Tasa de Normalidad (%)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Semanas'
                    }
                }
            }
        }
    });
    @endif
});
</script>
@endsection