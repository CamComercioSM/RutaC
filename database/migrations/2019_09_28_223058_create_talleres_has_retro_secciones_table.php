<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalleresHasRetroSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talleres_has_retro_secciones', function (Blueprint $table) {
            $table->integer('talleres_taller_id')->unsigned();
            $table->integer('r_s_retro_seccion_id')->unsigned();
        });

        Schema::table('talleres_has_retro_secciones', function($table) {
            $table->foreign('talleres_taller_id')->references('tallerID')->on('talleres');
            $table->foreign('r_s_retro_seccion_id')->references('retro_seccionID')->on('retro_secciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talleres_has_retro_secciones');
    }
}
