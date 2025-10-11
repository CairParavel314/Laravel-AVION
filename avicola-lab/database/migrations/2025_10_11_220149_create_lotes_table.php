<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('granja_id')->constrained()->onDelete('cascade');
            $table->string('codigo_lote')->unique();
            $table->date('fecha_ingreso');
            $table->integer('numero_aves');
            $table->string('raza');
            $table->enum('estado', ['activo', 'finalizado', 'en_cuarentena'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotes');
    }
};