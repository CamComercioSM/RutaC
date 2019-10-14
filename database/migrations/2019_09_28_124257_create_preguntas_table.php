<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->increments('preguntaID');
            $table->integer('SECCIONES_PREGUNTAS_seccion_pregunta')->unsigned();
            $table->integer('COMPETENCIAS_competenciaID')->unsigned()->nullable();
            $table->integer('preguntaORDEN')->default('99');
            $table->string('preguntaENUNCIADO',255);
            $table->enum('preguntaESTADO',['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('preguntas', function($table) {
            $table->foreign('SECCIONES_PREGUNTAS_seccion_pregunta')->references('seccion_preguntaID')->on('secciones_preguntas');
            $table->foreign('COMPETENCIAS_competenciaID')->references('competenciaID')->on('competencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas');
    }
}
