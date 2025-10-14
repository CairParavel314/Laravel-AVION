@extends('layouts.app')

@section('title', 'Dashboard Avanzado - Reportes')

@section('content')
<div class="space-y-6">
    <!-- Header y Filtros -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start space-y-4 lg:space-y-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Avanzado</h1>
                    <p class="text-gray-600 mt-1">Estadísticas detalladas con histogramas y comparativas</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Actualizado: {{ now()->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Filtros -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('reportes.dashboard-avanzado') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Selector de Semanas -->
                <div>
                    <label for="semanas" class="block text-sm font-medium text-gray-700 mb-1">Rango de Tiempo</label>
                    <select name="semanas" id="semanas" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach([4, 8, 12, 26, 52] as $numSemanas)
                        <option value="{{ $numSemanas }}" {{ $semanas == $numSemanas ? 'selected' : '' }}>
                            Últimas {{ $numSemanas }} semanas
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tipo de Comparación -->
                <div>
                    <label for="tipo_comparacion" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Análisis</label>
                    <select name="tipo_comparacion" id="tipo_comparacion" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="general" {{ $tipoComparacion == 'general' ? 'selected' : '' }}>General</option>
                        <option value="granja" {{ $tipoComparacion == 'granja' ? 'selected' : '' }}>Por Granja</option>
                        <option value="lote" {{ $tipoComparacion == 'lote' ? 'selected' : '' }}>Por Lote</option>
                    </select>
                </div>

                <!-- Selector de Granja (solo visible cuando se selecciona por granja) -->
                <div id="granja-selector" style="{{ $tipoComparacion != 'granja' ? 'display: none;' : '' }}">
                    <label for="granja_id" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar Granja</label>
                    <select name="granja_id" id="granja_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las granjas</option>
                        @foreach($granjas as $granja)
                        <option value="{{ $granja->id }}" {{ $granjaId == $granja->id ? 'selected' : '' }}>
                            {{ $granja->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Selector de Lote (solo visible cuando se selecciona por lote) -->
                <div id="lote-selector" style="{{ $tipoComparacion != 'lote' ? 'display: none;' : '' }}">
                    <label for="lote_id" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar Lote</label>
                    <select name="lote_id" id="lote_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos los lotes</option>
                        @foreach($lotes as $lote)
                        <option value="{{ $lote->id }}" {{ $loteId == $lote->id ? 'selected' : '' }}>
                            {{ $lote->codigo_lote }} - {{ $lote->granja->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botones de acción -->
                <div class="flex items-end space-x-2 md:col-span-2 lg:col-span-1">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i>Generar Reporte
                    </button>
                    <a href="{{ route('reportes.dashboard-avanzado') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition flex items-center">
                        <i class="fas fa-redo mr-2"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-home text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Granjas</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total_granjas'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-list text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Lotes</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total_lotes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-flask text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Pruebas ({{ $semanas }} sem)</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['pruebas_periodo'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <i class="fas fa-chart-line text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Tasa Anormalidad</h3>
                    <p class="text-2xl font-bold text-gray-900 {{ $estadisticas['tasa_anormalidad'] > 10 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $estadisticas['tasa_anormalidad'] }}%
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Histograma Principal de Pruebas por Semana -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Histograma de Pruebas - Últimas {{ $semanas }} Semanas</h3>
            <p class="text-sm text-gray-600 mt-1">Distribución temporal de pruebas por resultado</p>
        </div>
        <div class="p-6">
            <div class="h-80">
                <canvas id="histogramaPruebasChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico de Distribución por Tipo de Prueba -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Distribución por Tipo de Prueba</h3>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="tipoPruebaChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Resultados -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Distribución por Resultado</h3>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="resultadoChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparativa entre Granjas -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Comparativa entre Granjas (Top 5)</h3>
            <p class="text-sm text-gray-600 mt-1">Rendimiento comparativo por tasa de pruebas normales</p>
        </div>
        <div class="p-6">
            <div class="h-64">
                <canvas id="comparativaGranjasChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabla de Parámetros Más Comunes -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Parámetros Más Analizados</h3>
            <p class="text-sm text-gray-600 mt-1">Top 10 parámetros más frecuentes en las pruebas</p>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parámetro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Pruebas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frecuencia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distribución</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($comparativas['por_parametro'] as $parametro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $parametro->parametro }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $parametro->total }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ round(($parametro->total / $estadisticas['pruebas_periodo']) * 100, 1) }}%
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" 
                                         style="width: {{ ($parametro->total / $estadisticas['pruebas_periodo']) * 100 }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar selectores basado en tipo de comparación
    const tipoComparacion = document.getElementById('tipo_comparacion');
    const granjaSelector = document.getElementById('granja-selector');
    const loteSelector = document.getElementById('lote-selector');

    tipoComparacion.addEventListener('change', function() {
        if (this.value === 'granja') {
            granjaSelector.style.display = 'block';
            loteSelector.style.display = 'none';
        } else if (this.value === 'lote') {
            granjaSelector.style.display = 'none';
            loteSelector.style.display = 'block';
        } else {
            granjaSelector.style.display = 'none';
            loteSelector.style.display = 'none';
        }
    });

    // Histograma de Pruebas por Semana
    const histogramaCtx = document.getElementById('histogramaPruebasChart').getContext('2d');
    const histogramaChart = new Chart(histogramaCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($histogramaPruebas->pluck('semana')) !!},
            datasets: [
                {
                    label: 'Normales',
                    data: {!! json_encode($histogramaPruebas->pluck('normales')) !!},
                    backgroundColor: '#10B981',
                    borderColor: '#10B981',
                    borderWidth: 1
                },
                {
                    label: 'Anormales',
                    data: {!! json_encode($histogramaPruebas->pluck('anormales')) !!},
                    backgroundColor: '#F59E0B',
                    borderColor: '#F59E0B',
                    borderWidth: 1
                },
                {
                    label: 'Críticas',
                    data: {!! json_encode($histogramaPruebas->pluck('criticas')) !!},
                    backgroundColor: '#EF4444',
                    borderColor: '#EF4444',
                    borderWidth: 1
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
                    intersect: false
                }
            },
            scales: {
                x: {
                    stacked: false,
                },
                y: {
                    stacked: false,
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad de Pruebas'
                    }
                }
            }
        }
    });

    // Gráfico de Distribución por Tipo de Prueba
    const tipoCtx = document.getElementById('tipoPruebaChart').getContext('2d');
    const tipoChart = new Chart(tipoCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($comparativas['por_tipo']->pluck('tipo_prueba')) !!},
            datasets: [{
                data: {!! json_encode($comparativas['por_tipo']->pluck('total')) !!},
                backgroundColor: [
                    '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4', '#F97316', '#84CC16'
                ],
                borderWidth: 2,
                borderColor: '#FFFFFF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico de Resultados
    const resultadoCtx = document.getElementById('resultadoChart').getContext('2d');
    const resultadoChart = new Chart(resultadoCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($comparativas['por_resultado']->pluck('resultado')) !!},
            datasets: [{
                data: {!! json_encode($comparativas['por_resultado']->pluck('total')) !!},
                backgroundColor: [
                    '#10B981', '#F59E0B', '#EF4444'
                ],
                borderWidth: 2,
                borderColor: '#FFFFFF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Comparativa entre Granjas
    const comparativaCtx = document.getElementById('comparativaGranjasChart').getContext('2d');
    const comparativaChart = new Chart(comparativaCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($comparativas['comparativa_granjas']->pluck('nombre')) !!},
            datasets: [
                {
                    label: 'Total Pruebas',
                    data: {!! json_encode($comparativas['comparativa_granjas']->pluck('total_pruebas')) !!},
                    backgroundColor: '#3B82F6',
                    borderColor: '#3B82F6',
                    borderWidth: 1
                },
                {
                    label: 'Tasa Normalidad (%)',
                    data: {!! json_encode($comparativas['comparativa_granjas']->pluck('tasa_normal')) !!},
                    backgroundColor: '#10B981',
                    borderColor: '#10B981',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Pruebas'
                    }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Tasa Normalidad (%)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
});
</script>
@endsection