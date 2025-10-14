<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'fecha_prueba' => 'date',
        'valor' => 'decimal:2',
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    // Accesor para la granja a través del lote
    public function getGranjaAttribute()
    {
        return $this->lote->granja;
    }

    // Scopes para filtros comunes
    public function scopeRecientes($query, $semanas = 4)
    {
        return $query->where('fecha_prueba', '>=', now()->subWeeks($semanas));
    }

    public function scopePorResultado($query, $resultado)
    {
        return $query->where('resultado', $resultado);
    }

    public function scopeAnormales($query)
    {
        return $query->whereIn('resultado', ['anormal', 'critico']);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_prueba', $tipo);
    }

    public function scopePorGranja($query, $granjaId)
    {
        return $query->whereHas('lote', function($q) use ($granjaId) {
            $q->where('granja_id', $granjaId);
        });
    }

    public function scopePorLote($query, $loteId)
    {
        return $query->where('lote_id', $loteId);
    }
}