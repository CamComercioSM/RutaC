<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeccionesPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secciones_preguntas', function (Blueprint $table) {
            $table->increments('seccion_preguntaID');
            $table->integer('TIPO_DIAGNOSTICOS_tipo_diagnosticoID')->unsigned();
            $table->string('seccion_preguntaNOMBRE',45);
            $table->integer('seccion_preguntaPESO');
            $table->enum('seccion_preguntaESTADO',['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('secciones_preguntas', function($table) {
            $table->foreign('TIPO_DIAGNOSTICOS_tipo_diagnosticoID')->references('tipo_diagnosticoID')->on('tipos_diagnosticos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secciones_preguntas');
    }
}
