<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetroSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retro_secciones', function (Blueprint $table) {
            $table->increments('retro_seccionID');
            $table->integer('SECCIONES_PREGUNTAS_seccion_pregunta')->unsigned();
            $table->integer('TALLERES_tallerID')->unsigned();
            $table->string('retro_seccionNIVEL',45);
            $table->string('retro_seccionRANGO',45);
            $table->string('retro_seccionMENSAJE',255);
            $table->enum('retro_seccionESTADO',['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('retro_secciones', function($table) {
            $table->foreign('SECCIONES_PREGUNTAS_seccion_pregunta')->references('seccion_preguntaID')->on('secciones_preguntas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retro_secciones');
    }
}
