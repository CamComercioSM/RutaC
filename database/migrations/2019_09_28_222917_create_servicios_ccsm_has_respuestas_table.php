<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosCcsmHasRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_ccsm_has_respuestas', function (Blueprint $table) {
            $table->integer('S_CCSM_servicio_ccsmID')->unsigned();
            $table->integer('RESPUESTAS_respuestaID')->unsigned();
        });

        Schema::table('servicios_ccsm_has_respuestas', function($table) {
            $table->foreign('S_CCSM_servicio_ccsmID')->references('servicio_ccsmID')->on('servicios_ccsm');
            $table->foreign('RESPUESTAS_respuestaID')->references('respuestaID')->on('respuestas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios_ccsm_has_respuestas');
    }
}
