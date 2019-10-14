<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialesAyudaHasRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiales_ayuda_has_respuestas', function (Blueprint $table) {
            $table->integer('M_AYUDA_material_ayudaID')->unsigned();
            $table->integer('RESPUESTAS_respuestaID')->unsigned();
        });

        Schema::table('materiales_ayuda_has_respuestas', function($table) {
            $table->foreign('M_AYUDA_material_ayudaID')->references('material_ayudaID')->on('materiales_ayuda');
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
        Schema::dropIfExists('materiales_ayuda_has_respuestas');
    }
}
