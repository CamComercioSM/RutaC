<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetroTipoDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retro_tipo_diagnostico', function (Blueprint $table) {
            $table->increments('retro_tipo_diagnosticoID');
            $table->integer('T_DIAGNOSTICOS_tipo_diagnosticoID')->unsigned();
            $table->string('retro_tipo_diagnosticoRANGO',45);
            $table->string('retro_tipo_diagnosticoNIVEL',20);
            $table->text('retro_tipo_diagnosticoMensaje');
            $table->enum('retro_seccionESTADO',['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('retro_tipo_diagnostico', function($table) {
            $table->foreign('T_DIAGNOSTICOS_tipo_diagnosticoID')->references('tipo_diagnosticoID')->on('tipos_diagnosticos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retro_tipo_diagnostico');
    }
}
