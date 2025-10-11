<?php

namespace App\Http\Controllers;

use App\Models\Prueba;
use App\Models\Lote;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function index()
    {
        $pruebas = Prueba::with('lote.granja')->get();
        return view('pruebas.index', compact('pruebas'));
    }

    public function create()
    {
        $lotes = Lote::where('estado', 'activo')->get();
        return view('pruebas.create', compact('lotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'tipo_prueba' => 'required|string|max:255',
            'fecha_prueba' => 'required|date',
            'parametro' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'unidad_medida' => 'required|string|max:50',
            'resultado' => 'required|in:normal,anormal,critico',
            'realizada_por' => 'required|string|max:255',
        ]);

        Prueba::create($request->all());

        return redirect()->route('pruebas.index')
            ->with('success', 'Prueba registrada exitosamente.');
    }

    public function show(Prueba $prueba)
    {
        return view('pruebas.show', compact('prueba'));
    }

    public function edit(Prueba $prueba)
    {
        $lotes = Lote::where('estado', 'activo')->get();
        return view('pruebas.edit', compact('prueba', 'lotes'));
    }

    public function update(Request $request, Prueba $prueba)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'tipo_prueba' => 'required|string|max:255',
            'fecha_prueba' => 'required|date',
            'parametro' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'unidad_medida' => 'required|string|max:50',
            'resultado' => 'required|in:normal,anormal,critico',
            'realizada_por' => 'required|string|max:255',
        ]);

        $prueba->update($request->all());

        return redirect()->route('pruebas.index')
            ->with('success', 'Prueba actualizada exitosamente.');
    }

    public function destroy(Prueba $prueba)
    {
        $prueba->delete();

        return redirect()->route('pruebas.index')
            ->with('success', 'Prueba eliminada exitosamente.');
    }
}