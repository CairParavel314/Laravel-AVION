<?php

namespace Database\Seeders;

use App\Models\Prueba;
use App\Models\Lote;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PruebasSampleSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los lotes disponibles
        $lotes = Lote::all();
        
        if ($lotes->isEmpty()) {
            $this->command->warn('No hay lotes disponibles. Ejecuta primero los seeders de Granjas y Lotes.');
            return;
        }

        $pruebas = [];

        // Tipos de pruebas y sus parámetros comunes
        $tiposPruebas = [
            'alimento' => [
                ['parametro' => 'Proteína', 'unidad' => '%', 'min' => 16, 'max' => 20],
                ['parametro' => 'Calcio', 'unidad' => '%', 'min' => 3.5, 'max' => 4.5],
                ['parametro' => 'Fósforo', 'unidad' => '%', 'min' => 0.4, 'max' => 0.8],
                ['parametro' => 'Energía Metabolizable', 'unidad' => 'kcal/kg', 'min' => 2800, 'max' => 3200],
                ['parametro' => 'Fibra Cruda', 'unidad' => '%', 'min' => 3, 'max' => 6],
                ['parametro' => 'Grasa', 'unidad' => '%', 'min' => 3, 'max' => 6],
                ['parametro' => 'Humedad', 'unidad' => '%', 'min' => 10, 'max' => 14],
                ['parametro' => 'Cenizas', 'unidad' => '%', 'min' => 10, 'max' => 15],
            ],
            'laboratorio' => [
                ['parametro' => 'Salmonella', 'unidad' => 'UFC/g', 'min' => 0, 'max' => 0],
                ['parametro' => 'E. coli', 'unidad' => 'UFC/g', 'min' => 0, 'max' => 100],
                ['parametro' => 'Coliformes', 'unidad' => 'UFC/g', 'min' => 0, 'max' => 1000],
                ['parametro' => 'Recuento Aerobio', 'unidad' => 'UFC/g', 'min' => 0, 'max' => 100000],
                ['parametro' => 'Listeria', 'unidad' => 'UFC/g', 'min' => 0, 'max' => 0],
                ['parametro' => 'Campylobacter', 'unidad' => 'UFC/g', 'min' => 0, 'max' => 100],
            ],
            'sanidad' => [
                ['parametro' => 'Hemograma - Hematocrito', 'unidad' => '%', 'min' => 28, 'max' => 35],
                ['parametro' => 'Hemograma - Leucocitos', 'unidad' => 'x10³/μL', 'min' => 15, 'max' => 30],
                ['parametro' => 'Proteína Total', 'unidad' => 'g/dL', 'min' => 3.5, 'max' => 5.5],
                ['parametro' => 'Glucosa', 'unidad' => 'mg/dL', 'min' => 180, 'max' => 260],
                ['parametro' => 'Calcio Sanguíneo', 'unidad' => 'mg/dL', 'min' => 8, 'max' => 12],
            ],
            'ambiental' => [
                ['parametro' => 'Temperatura Galpón', 'unidad' => '°C', 'min' => 18, 'max' => 24],
                ['parametro' => 'Humedad Relativa', 'unidad' => '%', 'min' => 50, 'max' => 70],
                ['parametro' => 'Nivel Amoníaco', 'unidad' => 'ppm', 'min' => 0, 'max' => 25],
                ['parametro' => 'Dióxido de Carbono', 'unidad' => 'ppm', 'min' => 0, 'max' => 3000],
                ['parametro' => 'Iluminación', 'unidad' => 'lux', 'min' => 10, 'max' => 30],
            ],
            'calidad' => [
                ['parametro' => 'Peso Huevo', 'unidad' => 'g', 'min' => 55, 'max' => 65],
                ['parametro' => 'Unidad Haugh', 'unidad' => 'UH', 'min' => 70, 'max' => 90],
                ['parametro' => 'Espesor Cáscara', 'unidad' => 'mm', 'min' => 0.33, 'max' => 0.38],
                ['parametro' => 'Color Yema', 'unidad' => 'DSM', 'min' => 8, 'max' => 12],
                ['parametro' => 'Índice Albúmina', 'unidad' => 'unidad', 'min' => 0.07, 'max' => 0.10],
            ]
        ];

        // Personal que realiza las pruebas
        $realizadasPor = [
            'Dr. Carlos Mendoza', 
            'Dra. Ana López', 
            'Lab. Central Avícola',
            'Téc. Javier Ruiz',
            'Lab. Calidad Alimentos',
            'Dr. Roberto Silva',
            'Téc. María González'
        ];

        // Generar 50 pruebas de muestra
        for ($i = 0; $i < 50; $i++) {
            // Seleccionar lote aleatorio
            $lote = $lotes->random();
            
            // Seleccionar tipo de prueba aleatorio
            $tipoPrueba = array_rand($tiposPruebas);
            $parametrosTipo = $tiposPruebas[$tipoPrueba];
            $parametroConfig = $parametrosTipo[array_rand($parametrosTipo)];
            
            // Generar valor aleatorio dentro del rango o fuera para crear anomalías
            $esAnormal = rand(1, 10) === 1; // 10% de probabilidad de ser anormal
            $esCritico = rand(1, 20) === 1; // 5% de probabilidad de ser crítico
            
            $valor = $this->generarValor(
                $parametroConfig['min'], 
                $parametroConfig['max'], 
                $esAnormal, 
                $esCritico,
                $parametroConfig['parametro']
            );
            
            // Determinar resultado basado en el valor
            $resultado = $this->determinarResultado($valor, $parametroConfig['min'], $parametroConfig['max'], $esCritico);
            
            // Fecha aleatoria en los últimos 3 meses
            $fechaPrueba = Carbon::now()->subDays(rand(0, 90))->subHours(rand(0, 23));
            
            $pruebas[] = [
                'lote_id' => $lote->id,
                'tipo_prueba' => $tipoPrueba,
                'fecha_prueba' => $fechaPrueba,
                'parametro' => $parametroConfig['parametro'],
                'valor' => $valor,
                'unidad_medida' => $parametroConfig['unidad'],
                'resultado' => $resultado,
                'observaciones' => $this->generarObservaciones($resultado, $parametroConfig['parametro'], $valor),
                'realizada_por' => $realizadasPor[array_rand($realizadasPor)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertar las pruebas
        Prueba::insert($pruebas);
        
        $this->command->info('50 pruebas de muestra creadas exitosamente.');
    }

    private function generarValor($min, $max, $esAnormal, $esCritico, $parametro)
    {
        if ($esCritico) {
            // Valor crítico - muy fuera de rango
            $desviacion = ($max - $min) * (rand(15, 30) / 10);
            return rand(0, 1) ? $min - $desviacion : $max + $desviacion;
        }
        
        if ($esAnormal) {
            // Valor anormal - ligeramente fuera de rango
            $desviacion = ($max - $min) * 0.3;
            return rand(0, 1) ? $min - $desviacion : $max + $desviacion;
        }
        
        // Valor normal - dentro del rango
        return $min + (($max - $min) * (rand(0, 100) / 100));
    }

    private function determinarResultado($valor, $min, $max, $esCritico)
    {
        if ($esCritico) {
            return 'critico';
        }
        
        if ($valor < $min || $valor > $max) {
            return 'anormal';
        }
        
        return 'normal';
    }

    private function generarObservaciones($resultado, $parametro, $valor)
    {
        $observacionesNormales = [
            "Valor dentro de parámetros normales",
            "Resultado satisfactorio",
            "Cumple con especificaciones",
            "Parámetro en rango óptimo",
            "Sin observaciones relevantes",
            "Desempeño adecuado"
        ];
        
        $observacionesAnormales = [
            "Valor ligeramente fuera de rango, monitorear",
            "Requiere ajuste en formulación",
            "Verificar condiciones ambientales",
            "Posible contaminación cruzada",
            "Necesita seguimiento continuo",
            "Ajustar protocolo de alimentación"
        ];
        
        $observacionesCriticas = [
            "¡VALOR CRÍTICO! Tomar acción inmediata",
            "Suspender lote para investigación",
            "Notificar a autoridades sanitarias",
            "Aislamiento preventivo requerido",
            "Revisar todo el proceso de producción",
            "Contaminación confirmada - cuarentena"
        ];

        switch ($resultado) {
            case 'normal':
                return $observacionesNormales[array_rand($observacionesNormales)];
            case 'anormal':
                return $observacionesAnormales[array_rand($observacionesAnormales)];
            case 'critico':
                return $observacionesCriticas[array_rand($observacionesCriticas)];
            default:
                return "Sin observaciones";
        }
    }
}