<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadoseccionesestacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultadoseccionesestaciones', function (Blueprint $table) {
            $table->increments('ResultadoSeccionEstacionID');
            $table->integer('ResultadoSeccionID')->unsigned();
            $table->integer('EstacioAyudaID')->unsigned()->nullable();
        });

        Schema::table('resultadoseccionesestaciones', function($table) {
            $table->foreign('ResultadoSeccionID')->references('resultado_seccionID')->on('resultados_seccion');
            $table->foreign('EstacioAyudaID')->references('estacionID')->on('estaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultadoseccionesestaciones');
    }
}
