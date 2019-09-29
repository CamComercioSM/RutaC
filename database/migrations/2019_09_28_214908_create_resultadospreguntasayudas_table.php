<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadospreguntasayudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultadospreguntasayudas', function (Blueprint $table) {
            $table->increments('RutaAyudaID');
            $table->integer('ResultadoPreguntaID')->unsigned();
            $table->integer('EstacionAyudaID')->unsigned()->nullable();
        });

        Schema::table('resultadospreguntasayudas', function($table) {
            $table->foreign('ResultadoPreguntaID')->references('resultado_preguntaID')->on('resultados_preguntas');
            $table->foreign('EstacionAyudaID')->references('estacionID')->on('estaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultadospreguntasayudas');
    }
}
