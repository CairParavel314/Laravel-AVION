<?php

namespace Database\Seeders;

use App\Models\Granja;
use App\Models\Lote;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GranjasLotesBaseSeeder extends Seeder
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
            ],
            [
                'nombre' => 'Granja Los Pinos',
                'ubicacion' => 'Antioquia',
                'responsable' => 'Ana Martínez',
                'telefono' => '3155551234',
                'email' => 'ana@pinos.com',
                'descripcion' => 'Granja familiar con enfoque en bienestar animal'
            ],
            [
                'nombre' => 'Avícola El Progreso',
                'ubicacion' => 'Santander',
                'responsable' => 'José López',
                'telefono' => '3184445678',
                'email' => 'jose@progreso.com',
                'descripcion' => 'Tecnología avanzada en producción avícola'
            ]
        ];

        foreach ($granjas as $granjaData) {
            $granja = Granja::create($granjaData);

            // Crear lotes para cada granja (3-4 lotes por granja)
            $numeroLotes = rand(3, 4);
            for ($i = 1; $i <= $numeroLotes; $i++) {
                Lote::create([
                    'granja_id' => $granja->id,
                    'codigo_lote' => 'LOTE-' . $granja->id . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'fecha_ingreso' => Carbon::now()->subDays(rand(10, 120)),
                    'numero_aves' => rand(2000, 8000),
                    'raza' => $this->obtenerRazaAleatoria(),
                    'estado' => $this->obtenerEstadoAleatorio(),
                    'observaciones' => $this->generarObservacionesLote(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Granjas y lotes base creados exitosamente.');
    }

    private function obtenerRazaAleatoria()
    {
        $razas = [
            'Lohmann Brown',
            'Hy-Line Brown', 
            'Isa Brown',
            'Babcock',
            'Hubbard',
            'Cobb',
            'Ross',
            'Arbor Acres'
        ];
        
        return $razas[array_rand($razas)];
    }

    private function obtenerEstadoAleatorio()
    {
        $estados = ['activo', 'activo', 'activo', 'en_cuarentena', 'finalizado'];
        return $estados[array_rand($estados)];
    }

    private function generarObservacionesLote()
    {
        $observaciones = [
            'Lote en crecimiento normal',
            'Excelente desarrollo',
            'Requiere monitoreo constante',
            'Ajuste en alimentación aplicado',
            'Condiciones ambientales óptimas',
            'Programa de vacunación completo',
            'Buen estado sanitario',
            null
        ];
        
        return $observaciones[array_rand($observaciones)];
    }
}