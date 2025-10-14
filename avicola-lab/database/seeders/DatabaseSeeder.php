<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            GranjasLotesBaseSeeder::class,  // Primero granjas y lotes
            PruebasSampleSeeder::class,     // Luego las 50 pruebas
        ]);
    }
}