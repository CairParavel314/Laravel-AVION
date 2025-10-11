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
}