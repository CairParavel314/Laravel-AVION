<?php

namespace Database\Seeders;

use App\Models\Granja;
use App\Models\Lote;
use App\Models\Prueba;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear granjas
        $granjas = [
            [
                'nombre' => 'Granja La Esperanza',
                'ubicacion' => 'Valle del Cauca',
                'responsable' => 'María González',
                'telefono' => '3101234567',
                'email' => 'maria@esperanza.com',
                'descripcion' => 'Granja especializada en producción de huevo orgánico'
            ],
            [
                'nombre' => 'Avícola San José',
                'ubicacion' => 'Cundinamarca',
                'responsable' => 'Carlos Rodríguez',
                'telefono' => '3209876543',
                'email' => 'carlos@sanjose.com',
                'descripcion' => 'Producción avícola con estándares internacionales'
            ]
        ];

        foreach ($granjas as $granjaData) {
            $granja = Granja::create($granjaData);

            // Crear lotes para cada granja
            $lotes = [
                [
                    'codigo_lote' => 'LOTE-' . $granja->id . '-001',
                    'fecha_ingreso' => now()->subDays(30),
                    'numero_aves' => 5000,
                    'raza' => 'Lohmann Brown',
                    'estado' => 'activo',
                    'observaciones' => 'Lote en crecimiento'
                ],
                [
                    'codigo_lote' => 'LOTE-' . $granja->id . '-002',
                    'fecha_ingreso' => now()->subDays(15),
                    'numero_aves' => 3000,
                    'raza' => 'Hy-Line Brown',
                    'estado' => 'activo',
                    'observaciones' => 'Lote nuevo ingresado'
                ]
            ];

            foreach ($lotes as $loteData) {
                $lote = $granja->lotes()->create($loteData);

                // Crear pruebas para cada lote
                $pruebas = [
                    [
                        'tipo_prueba' => 'alimento',
                        'fecha_prueba' => now()->subDays(2),
                        'parametro' => 'Proteína',
                        'valor' => 18.5,
                        'unidad_medida' => '%',
                        'resultado' => 'normal',
                        'observaciones' => 'Niveles óptimos',
                        'realizada_por' => 'Lab. Central'
                    ],
                    [
                        'tipo_prueba' => 'laboratorio',
                        'fecha_prueba' => now()->subDays(1),
                        'parametro' => 'Salmonella',
                        'valor' => 0,
                        'unidad_medida' => 'UFC/g',
                        'resultado' => 'normal',
                        'observaciones' => 'Resultado negativo',
                        'realizada_por' => 'Dr. Pérez'
                    ]
                ];

                foreach ($pruebas as $pruebaData) {
                    $lote->pruebas()->create($pruebaData);
                }
            }
        }
    }
}