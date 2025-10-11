<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Granja;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index()
    {
        $lotes = Lote::with('granja')->get();
        return view('lotes.index', compact('lotes'));
    }

    public function create()
    {
        $granjas = Granja::all();
        return view('lotes.create', compact('granjas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'granja_id' => 'required|exists:granjas,id',
            'codigo_lote' => 'required|unique:lotes',
            'fecha_ingreso' => 'required|date',
            'numero_aves' => 'required|integer|min:1',
            'raza' => 'required|string|max:255',
            'estado' => 'required|in:activo,finalizado,en_cuarentena',
        ]);

        Lote::create($request->all());

        return redirect()->route('lotes.index')
            ->with('success', 'Lote creado exitosamente.');
    }

    public function show(Lote $lote)
    {
        return view('lotes.show', compact('lote'));
    }

    public function edit(Lote $lote)
    {
        $granjas = Granja::all();
        return view('lotes.edit', compact('lote', 'granjas'));
    }

    public function update(Request $request, Lote $lote)
    {
        $request->validate([
            'granja_id' => 'required|exists:granjas,id',
            'codigo_lote' => 'required|unique:lotes,codigo_lote,' . $lote->id,
            'fecha_ingreso' => 'required|date',
            'numero_aves' => 'required|integer|min:1',
            'raza' => 'required|string|max:255',
            'estado' => 'required|in:activo,finalizado,en_cuarentena',
        ]);

        $lote->update($request->all());

        return redirect()->route('lotes.index')
            ->with('success', 'Lote actualizado exitosamente.');
    }

    public function destroy(Lote $lote)
    {
        $lote->delete();

        return redirect()->route('lotes.index')
            ->with('success', 'Lote eliminado exitosamente.');
    }
}