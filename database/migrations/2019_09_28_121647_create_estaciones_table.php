<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estaciones', function (Blueprint $table) {
            $table->increments('estacionID');
            $table->integer('RUTAS_rutaID')->unsigned();
            $table->integer('TALLERES_tallerID')->unsigned()->nullable();
            $table->integer('MATERIALES_AYUDA_material_ayudaID')->unsigned()->nullable();
            $table->integer('SERVICIOS_CCSM_servicio_ccsmID')->unsigned()->nullable();
            $table->string('estacionNOMBRE',255);
            $table->enum('estacionCUMPLIMIENTO',['Si', 'No'])->default('No');
            $table->timestamps();
        });

        Schema::table('estaciones', function($table) {
            $table->foreign('RUTAS_rutaID')->references('rutaID')->on('rutas');
            $table->foreign('TALLERES_tallerID')->references('tallerID')->on('talleres');
            $table->foreign('MATERIALES_AYUDA_material_ayudaID')->references('material_ayudaID')->on('materiales_ayuda');
            $table->foreign('SERVICIOS_CCSM_servicio_ccsmID')->references('servicio_ccsmID')->on('servicios_ccsm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estaciones');
    }
}
