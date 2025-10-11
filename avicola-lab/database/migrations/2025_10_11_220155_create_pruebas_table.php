<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pruebas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained()->onDelete('cascade');
            $table->string('tipo_prueba'); // alimento, laboratorio, etc.
            $table->date('fecha_prueba');
            $table->string('parametro');
            $table->decimal('valor', 8, 2);
            $table->string('unidad_medida');
            $table->enum('resultado', ['normal', 'anormal', 'critico']);
            $table->text('observaciones')->nullable();
            $table->string('realizada_por');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pruebas');
    }
};