<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Prueba extends Model
{
    use HasFactory;

    protected $fillable = [
        'lote_id',
        'tipo_prueba',
        'fecha_prueba',
        'parametro',
        'valor',
        'unidad_medida',
        'resultado',
        'observaciones',
        'realizada_por'
    ];

    // Convertir fecha_prueba a objeto Carbon
    protected $dates = [
        'fecha_prueba',
        'created_at',
        'updated_at'
    ];

    // O en Laravel 8+ usar casts
    protected $casts = [
        'fecha_prueba' => 'date',
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}