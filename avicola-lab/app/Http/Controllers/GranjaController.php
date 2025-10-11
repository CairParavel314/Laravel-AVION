<?php

namespace App\Http\Controllers;

use App\Models\Granja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GranjaController extends Controller
{
    public function index()
    {
        $granjas = Granja::withCount(['lotes' => function($query) {
            $query->where('estado', 'activo');
        }])->get();
        
        return view('granjas.index', compact('granjas'));
    }

    public function create()
    {
        return view('granjas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:granjas',
            'ubicacion' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'descripcion' => 'nullable|string',
        ]);

        try {
            Granja::create($request->all());
            
            return redirect()->route('granjas.index')
                ->with('success', 'Granja creada exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la granja: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Granja $granja)
    {
        // Cargar relaciones para mostrar detalles
        $granja->load(['lotes' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'lotes.pruebas']);
        
        $estadisticas = [
            'total_lotes' => $granja->lotes->count(),
            'lotes_activos' => $granja->lotes->where('estado', 'activo')->count(),
            'lotes_finalizados' => $granja->lotes->where('estado', 'finalizado')->count(),
            'total_pruebas' => $granja->lotes->flatMap->pruebas->count(),
        ];
        
        return view('granjas.show', compact('granja', 'estadisticas'));
    }

    public function edit(Granja $granja)
    {
        return view('granjas.edit', compact('granja'));
    }

    public function update(Request $request, Granja $granja)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:granjas,nombre,' . $granja->id,
            'ubicacion' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'descripcion' => 'nullable|string',
        ]);

        try {
            $granja->update($request->all());
            
            return redirect()->route('granjas.index')
                ->with('success', 'Granja actualizada exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la granja: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Granja $granja)
    {
        try {
            // Verificar si la granja tiene lotes asociados
            if ($granja->lotes()->count() > 0) {
                return redirect()->route('granjas.index')
                    ->with('error', 'No se puede eliminar la granja porque tiene lotes asociados.');
            }
            
            $granja->delete();
            
            return redirect()->route('granjas.index')
                ->with('success', 'Granja eliminada exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->route('granjas.index')
                ->with('error', 'Error al eliminar la granja: ' . $e->getMessage());
        }
    }

    // Método adicional para obtener estadísticas de una granja
    public function estadisticas(Granja $granja)
    {
        $estadisticas = DB::table('lotes')
            ->join('pruebas', 'lotes.id', '=', 'pruebas.lote_id')
            ->where('lotes.granja_id', $granja->id)
            ->select(
                DB::raw('COUNT(DISTINCT lotes.id) as total_lotes'),
                DB::raw('COUNT(pruebas.id) as total_pruebas'),
                DB::raw('SUM(CASE WHEN pruebas.resultado = "normal" THEN 1 ELSE 0 END) as pruebas_normales'),
                DB::raw('SUM(CASE WHEN pruebas.resultado = "anormal" THEN 1 ELSE 0 END) as pruebas_anormales'),
                DB::raw('SUM(CASE WHEN pruebas.resultado = "critico" THEN 1 ELSE 0 END) as pruebas_criticas')
            )
            ->first();

        return response()->json($estadisticas);
    }
}