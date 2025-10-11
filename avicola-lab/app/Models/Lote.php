<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'granja_id',
        'codigo_lote',
        'fecha_ingreso',
        'numero_aves',
        'raza',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    public function granja()
    {
        return $this->belongsTo(Granja::class);
    }

    public function pruebas()
    {
        return $this->hasMany(Prueba::class);
    }
}