<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosSeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados_seccion', function (Blueprint $table) {
            $table->increments('resultado_seccionID');
            $table->integer('seccionID')->unsigned();
            $table->integer('DIAGNOSTICOS_diagnosticoID')->unsigned();
            $table->string('resultado_seccionNOMBRE',255);
            $table->string('diagnostico_seccionPESO',45);
            $table->decimal('diagnostico_seccionRESULTADO', 10, 4);
            $table->string('diagnostico_seccionNIVEL',45);
            $table->string('diagnostico_seccionMENSAJE_FEEDBACK',255);
            $table->string('diagnostico_seccionTALLERES',255);
            $table->enum('diagnostico_seccionESTADO',['En Proceso', 'Finalizado', 'Guardado'])->default('En Proceso');
            $table->timestamps();
        });

        Schema::table('resultados_seccion', function($table) {
            $table->foreign('DIAGNOSTICOS_diagnosticoID')->references('diagnosticoID')->on('diagnosticos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultados_seccion');
    }
}
