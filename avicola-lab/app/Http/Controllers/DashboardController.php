<?php

namespace App\Http\Controllers;

use App\Models\Granja;
use App\Models\Lote;
use App\Models\Prueba;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $totalGranjas = Granja::count();
    $lotesActivos = Lote::where('estado', 'activo')->count();
    $totalPruebas = Prueba::count();
    $pruebasAnormales = Prueba::whereIn('resultado', ['anormal', 'critico'])->count();
    
    $ultimasPruebas = Prueba::with('lote')
        ->orderBy('fecha_prueba', 'desc')
        ->take(5)
        ->get();
        
    $granjas = Granja::withCount(['lotes' => function($query) {
        $query->where('estado', 'activo');
    }])->get();

    // Agregar lotes recientes
    $lotesRecientes = Lote::with('granja')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalGranjas',
        'lotesActivos',
        'totalPruebas',
        'pruebasAnormales',
        'ultimasPruebas',
        'granjas',
        'lotesRecientes' // Nueva variable
    )
);
}
}