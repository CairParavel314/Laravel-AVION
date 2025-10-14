<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Granja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ubicacion',
        'responsable',
        'telefono',
        'email',
        'descripcion'
    ];

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    // Nueva relación: Granja tiene muchas pruebas a través de lotes
    public function pruebas()
    {
        return $this->hasManyThrough(Prueba::class, Lote::class);
    }

    // Relación para contar pruebas con condiciones
    public function pruebasConResultado($resultado = null)
    {
        $query = $this->pruebas();
        
        if ($resultado) {
            $query->where('resultado', $resultado);
        }
        
        return $query;
    }
}