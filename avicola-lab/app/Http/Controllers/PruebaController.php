<?php

namespace App\Http\Controllers;

use App\Models\Prueba;
use App\Models\Lote;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function index()
    {
        $pruebas = Prueba::with('lote.granja')->latest()->get();
        return view('pruebas.index', compact('pruebas'));
    }

    public function create()
    {
        $lotes = Lote::where('estado', 'activo')->with('granja')->get();
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

        try {
            Prueba::create($request->all());

            return redirect()->route('pruebas.index')
                ->with('success', 'Prueba registrada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al registrar la prueba: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Prueba $prueba)
    {
        $prueba->load('lote.granja');
        return view('pruebas.show', compact('prueba'));
    }

    public function edit(Prueba $prueba)
    {
        $lotes = Lote::where('estado', 'activo')->with('granja')->get();
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

        try {
            $prueba->update($request->all());

            return redirect()->route('pruebas.show', $prueba)
                ->with('success', 'Prueba actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la prueba: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Prueba $prueba)
    {
        try {
            $lote_id = $prueba->lote_id;
            $prueba->delete();

            return redirect()->route('lotes.show', $lote_id)
                ->with('success', 'Prueba eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('pruebas.index')
                ->with('error', 'Error al eliminar la prueba: ' . $e->getMessage());
        }
    }
}