<?php

namespace App\Http\Controllers;

use App\Models\Granja;
use App\Models\Lote;
use App\Models\Prueba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function dashboardAvanzado(Request $request)
    {
        // Obtener parámetros de tiempo
        $semanas = $request->get('semanas', 12);
        $tipoComparacion = $request->get('tipo_comparacion', 'general');
        $granjaId = $request->get('granja_id');
        $loteId = $request->get('lote_id');

        // Calcular fecha de inicio basado en semanas
        $fechaInicio = now()->subWeeks($semanas);
        
        // Estadísticas generales
        $estadisticas = $this->obtenerEstadisticasGenerales($fechaInicio);
        
        // Histograma de pruebas por semana
        $histogramaPruebas = $this->obtenerHistogramaPruebas($fechaInicio, $semanas);
        
        // Comparativas
        $comparativas = $this->obtenerComparativas($fechaInicio, $tipoComparacion, $granjaId, $loteId);
        
        // Salud por granja
        $saludGranjas = $this->obtenerSaludGranjas($fechaInicio);
        
        // Alertas
        $alertas = $this->obtenerAlertas($fechaInicio);
        
        // Datos para filtros
        $granjas = Granja::all();
        $lotes = Lote::with('granja')->get();

        return view('reportes.dashboard-avanzado', compact(
            'estadisticas',
            'histogramaPruebas',
            'comparativas',
            'saludGranjas',
            'alertas',
            'granjas',
            'lotes',
            'semanas',
            'tipoComparacion',
            'granjaId',
            'loteId'
        ));
    }

    private function obtenerEstadisticasGenerales($fechaInicio)
    {
        $totalPruebasPeriodo = Prueba::where('fecha_prueba', '>=', $fechaInicio)->count();
        $pruebasAnormalesPeriodo = Prueba::where('fecha_prueba', '>=', $fechaInicio)
            ->whereIn('resultado', ['anormal', 'critico'])
            ->count();

        return [
            'total_granjas' => Granja::count(),
            'total_lotes' => Lote::count(),
            'total_pruebas' => Prueba::count(),
            'pruebas_periodo' => $totalPruebasPeriodo,
            'tasa_anormalidad' => $totalPruebasPeriodo > 0 ? 
                round(($pruebasAnormalesPeriodo / $totalPruebasPeriodo) * 100, 2) : 0,
        ];
    }

    private function obtenerHistogramaPruebas($fechaInicio, $semanas)
    {
        return Prueba::select(
                DB::raw('YEAR(fecha_prueba) as año'),
                DB::raw('WEEK(fecha_prueba, 1) as semana'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN resultado = "normal" THEN 1 ELSE 0 END) as normales'),
                DB::raw('SUM(CASE WHEN resultado = "anormal" THEN 1 ELSE 0 END) as anormales'),
                DB::raw('SUM(CASE WHEN resultado = "critico" THEN 1 ELSE 0 END) as criticas')
            )
            ->where('fecha_prueba', '>=', $fechaInicio)
            ->groupBy('año', 'semana')
            ->orderBy('año', 'desc')
            ->orderBy('semana', 'desc')
            ->limit($semanas)
            ->get()
            ->map(function ($item) {
                $fecha = Carbon::now();
                $fecha->setISODate($item->año, $item->semana);
                
                return [
                    'semana' => "Sem {$item->semana}",
                    'periodo' => $fecha->format('d/m'),
                    'total' => $item->total,
                    'normales' => $item->normales,
                    'anormales' => $item->anormales,
                    'criticas' => $item->criticas,
                    'tasa_normal' => $item->total > 0 ? round(($item->normales / $item->total) * 100, 1) : 0,
                ];
            })
            ->reverse()
            ->values();
    }

    private function obtenerComparativas($fechaInicio, $tipoComparacion, $granjaId, $loteId)
    {
        $query = Prueba::where('fecha_prueba', '>=', $fechaInicio);

        // Aplicar filtros según tipo de comparación
        if ($tipoComparacion === 'granja' && $granjaId) {
            $query->whereHas('lote', function($q) use ($granjaId) {
                $q->where('granja_id', $granjaId);
            });
        } elseif ($tipoComparacion === 'lote' && $loteId) {
            $query->where('lote_id', $loteId);
        }

        // Comparativa por tipo de prueba
        $porTipo = $query->clone()
            ->select('tipo_prueba', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo_prueba')
            ->get();

        // Comparativa por resultado
        $porResultado = $query->clone()
            ->select('resultado', DB::raw('COUNT(*) as total'))
            ->groupBy('resultado')
            ->get();

        // Comparativa por parámetro más común
        $porParametro = $query->clone()
            ->select('parametro', DB::raw('COUNT(*) as total'))
            ->groupBy('parametro')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // CORRECCIÓN: Usar una consulta directa en lugar de relaciones para comparativa de granjas
        $comparativaGranjas = DB::table('pruebas')
            ->join('lotes', 'pruebas.lote_id', '=', 'lotes.id')
            ->join('granjas', 'lotes.granja_id', '=', 'granjas.id')
            ->select(
                'granjas.id',
                'granjas.nombre',
                DB::raw('COUNT(pruebas.id) as total_pruebas'),
                DB::raw('SUM(CASE WHEN pruebas.resultado = "normal" THEN 1 ELSE 0 END) as pruebas_normales')
            )
            ->where('pruebas.fecha_prueba', '>=', $fechaInicio)
            ->groupBy('granjas.id', 'granjas.nombre')
            ->orderBy('total_pruebas', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'total_pruebas' => $item->total_pruebas,
                    'pruebas_normales' => $item->pruebas_normales,
                    'tasa_normal' => $item->total_pruebas > 0 ? 
                        round(($item->pruebas_normales / $item->total_pruebas) * 100, 1) : 0,
                ];
            });

        return [
            'por_tipo' => $porTipo,
            'por_resultado' => $porResultado,
            'por_parametro' => $porParametro,
            'comparativa_granjas' => $comparativaGranjas,
        ];
    }

    private function obtenerSaludGranjas($fechaInicio)
    {
        // CORRECCIÓN: Usar consulta directa para evitar problemas de relaciones
        return DB::table('granjas')
            ->leftJoin('lotes', 'granjas.id', '=', 'lotes.granja_id')
            ->leftJoin('pruebas', function($join) use ($fechaInicio) {
                $join->on('lotes.id', '=', 'pruebas.lote_id')
                     ->where('pruebas.fecha_prueba', '>=', $fechaInicio);
            })
            ->select(
                'granjas.id',
                'granjas.nombre',
                DB::raw('COUNT(DISTINCT lotes.id) as lotes_totales'),
                DB::raw('SUM(CASE WHEN lotes.estado = "activo" THEN 1 ELSE 0 END) as lotes_activos'),
                DB::raw('COUNT(pruebas.id) as total_pruebas'),
                DB::raw('SUM(CASE WHEN pruebas.resultado = "normal" THEN 1 ELSE 0 END) as pruebas_normales'),
                DB::raw('SUM(CASE WHEN pruebas.resultado IN ("anormal", "critico") THEN 1 ELSE 0 END) as pruebas_anormales')
            )
            ->groupBy('granjas.id', 'granjas.nombre')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'lotes_totales' => $item->lotes_totales,
                    'lotes_activos' => $item->lotes_activos,
                    'total_pruebas' => $item->total_pruebas,
                    'pruebas_normales' => $item->pruebas_normales,
                    'pruebas_anormales' => $item->pruebas_anormales,
                    'indice_salud' => $item->total_pruebas > 0 ? 
                        round(($item->pruebas_normales / $item->total_pruebas) * 100, 2) : 0,
                ];
            });
    }

    private function obtenerAlertas($fechaInicio)
    {
        return Prueba::with('lote.granja')
            ->whereIn('resultado', ['anormal', 'critico'])
            ->where('fecha_prueba', '>=', $fechaInicio)
            ->orderBy('fecha_prueba', 'desc')
            ->take(15)
            ->get();
    }
  public function comparativasAvanzadas(Request $request)
    {
        // Obtener parámetros
        $semanas = $request->get('semanas', 12);
        $tipoComparacion = $request->get('tipo_comparacion', 'granjas');
        $elemento1Id = $request->get('elemento1_id');
        $elemento2Id = $request->get('elemento2_id');
        $tipoPrueba = $request->get('tipo_prueba', 'todos');
        $parametro = $request->get('parametro', 'todos');

        // Calcular fecha de inicio
        $fechaInicio = now()->subWeeks($semanas);

        // Obtener datos para filtros
        $granjas = Granja::all();
        $lotes = Lote::with('granja')->get();
        
        // Obtener tipos de prueba y parámetros únicos
        $tiposPruebaUnicos = Prueba::distinct()->pluck('tipo_prueba');
        $parametrosUnicos = Prueba::distinct()->pluck('parametro');

        // Obtener datos comparativos
        $datosComparativa = $this->obtenerDatosComparativa(
            $tipoComparacion, 
            $elemento1Id, 
            $elemento2Id, 
            $fechaInicio, 
            $semanas,
            $tipoPrueba,
            $parametro
        );

        return view('reportes.comparativas-avanzadas', compact(
            'granjas',
            'lotes',
            'tiposPruebaUnicos',
            'parametrosUnicos',
            'datosComparativa',
            'semanas',
            'tipoComparacion',
            'elemento1Id',
            'elemento2Id',
            'tipoPrueba',
            'parametro'
        ));
    }

    private function obtenerDatosComparativa($tipoComparacion, $elemento1Id, $elemento2Id, $fechaInicio, $semanas, $tipoPrueba, $parametro)
    {
        if (!$elemento1Id || !$elemento2Id) {
            return null;
        }

        // Obtener datos para el primer elemento
        $datosElemento1 = $this->obtenerDatosElemento($tipoComparacion, $elemento1Id, $fechaInicio, $semanas, $tipoPrueba, $parametro);
        $datosElemento2 = $this->obtenerDatosElemento($tipoComparacion, $elemento2Id, $fechaInicio, $semanas, $tipoPrueba, $parametro);

        // Obtener histograma semanal comparativo
        $histogramaComparativo = $this->obtenerHistogramaComparativo(
            $tipoComparacion, 
            $elemento1Id, 
            $elemento2Id, 
            $fechaInicio, 
            $semanas,
            $tipoPrueba,
            $parametro
        );

        // Obtener estadísticas comparativas
        $estadisticasComparativas = $this->obtenerEstadisticasComparativas($datosElemento1, $datosElemento2);

        return [
            'elemento1' => $datosElemento1,
            'elemento2' => $datosElemento2,
            'histograma' => $histogramaComparativo,
            'estadisticas' => $estadisticasComparativas,
        ];
    }

    private function obtenerDatosElemento($tipoComparacion, $elementoId, $fechaInicio, $semanas, $tipoPrueba, $parametro)
    {
        $query = Prueba::where('fecha_prueba', '>=', $fechaInicio);

        // Aplicar filtros según tipo de comparación
        if ($tipoComparacion === 'granjas') {
            $query->whereHas('lote', function($q) use ($elementoId) {
                $q->where('granja_id', $elementoId);
            });
            $elemento = Granja::find($elementoId);
        } else {
            $query->where('lote_id', $elementoId);
            $elemento = Lote::with('granja')->find($elementoId);
        }

        // Aplicar filtros de tipo de prueba y parámetro
        if ($tipoPrueba !== 'todos') {
            $query->where('tipo_prueba', $tipoPrueba);
        }

        if ($parametro !== 'todos') {
            $query->where('parametro', $parametro);
        }

        $pruebas = $query->get();

        // Calcular estadísticas
        $totalPruebas = $pruebas->count();
        $pruebasNormales = $pruebas->where('resultado', 'normal')->count();
        $pruebasAnormales = $pruebas->where('resultado', 'anormal')->count();
        $pruebasCriticas = $pruebas->where('resultado', 'critico')->count();

        return [
            'elemento' => $elemento,
            'total_pruebas' => $totalPruebas,
            'pruebas_normales' => $pruebasNormales,
            'pruebas_anormales' => $pruebasAnormales,
            'pruebas_criticas' => $pruebasCriticas,
            'tasa_normalidad' => $totalPruebas > 0 ? round(($pruebasNormales / $totalPruebas) * 100, 2) : 0,
            'tasa_anormalidad' => $totalPruebas > 0 ? round((($pruebasAnormales + $pruebasCriticas) / $totalPruebas) * 100, 2) : 0,
            'distribucion_tipos' => $pruebas->groupBy('tipo_prueba')->map->count(),
            'distribucion_parametros' => $pruebas->groupBy('parametro')->map->count()->take(10),
        ];
    }

    private function obtenerHistogramaComparativo($tipoComparacion, $elemento1Id, $elemento2Id, $fechaInicio, $semanas, $tipoPrueba, $parametro)
    {
        $histograma = [];

        for ($i = 0; $i < $semanas; $i++) {
            $semanaFecha = Carbon::now()->subWeeks($semanas - $i - 1);
            $semanaNumero = $semanaFecha->week;
            $año = $semanaFecha->year;

            // Datos para elemento 1
            $query1 = Prueba::where('fecha_prueba', '>=', $fechaInicio)
                ->where(DB::raw('YEAR(fecha_prueba)'), $año)
                ->where(DB::raw('WEEK(fecha_prueba, 1)'), $semanaNumero);

            if ($tipoComparacion === 'granjas') {
                $query1->whereHas('lote', function($q) use ($elemento1Id) {
                    $q->where('granja_id', $elemento1Id);
                });
            } else {
                $query1->where('lote_id', $elemento1Id);
            }

            if ($tipoPrueba !== 'todos') {
                $query1->where('tipo_prueba', $tipoPrueba);
            }

            if ($parametro !== 'todos') {
                $query1->where('parametro', $parametro);
            }

            $total1 = $query1->count();
            $normales1 = $query1->clone()->where('resultado', 'normal')->count();

            // Datos para elemento 2
            $query2 = Prueba::where('fecha_prueba', '>=', $fechaInicio)
                ->where(DB::raw('YEAR(fecha_prueba)'), $año)
                ->where(DB::raw('WEEK(fecha_prueba, 1)'), $semanaNumero);

            if ($tipoComparacion === 'granjas') {
                $query2->whereHas('lote', function($q) use ($elemento2Id) {
                    $q->where('granja_id', $elemento2Id);
                });
            } else {
                $query2->where('lote_id', $elemento2Id);
            }

            if ($tipoPrueba !== 'todos') {
                $query2->where('tipo_prueba', $tipoPrueba);
            }

            if ($parametro !== 'todos') {
                $query2->where('parametro', $parametro);
            }

            $total2 = $query2->count();
            $normales2 = $query2->clone()->where('resultado', 'normal')->count();

            $histograma[] = [
                'semana' => "Sem {$semanaNumero}",
                'fecha' => $semanaFecha->format('d/m'),
                'elemento1_total' => $total1,
                'elemento1_normales' => $normales1,
                'elemento1_tasa' => $total1 > 0 ? round(($normales1 / $total1) * 100, 1) : 0,
                'elemento2_total' => $total2,
                'elemento2_normales' => $normales2,
                'elemento2_tasa' => $total2 > 0 ? round(($normales2 / $total2) * 100, 1) : 0,
            ];
        }

        return $histograma;
    }

    private function obtenerEstadisticasComparativas($datos1, $datos2)
    {
        return [
            'diferencia_total_pruebas' => $datos1['total_pruebas'] - $datos2['total_pruebas'],
            'diferencia_tasa_normalidad' => $datos1['tasa_normalidad'] - $datos2['tasa_normalidad'],
            'mejor_tasa_normalidad' => $datos1['tasa_normalidad'] > $datos2['tasa_normalidad'] ? 'elemento1' : 'elemento2',
            'ratio_pruebas' => $datos2['total_pruebas'] > 0 ? round($datos1['total_pruebas'] / $datos2['total_pruebas'], 2) : 0,
        ];
    }
}