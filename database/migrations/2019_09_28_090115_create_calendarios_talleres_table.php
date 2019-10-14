<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendariosTalleresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendarios_talleres', function (Blueprint $table) {
            $table->increments('calendario_tallerID');
            $table->integer('TALLERES_tallerID')->unsigned()->nullable();
            $table->dateTime('calendarioFECHA_INICIO');
            $table->dateTime('calendarioFECHA_FIN');
            $table->enum('calendarioESTADO',['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('calendarios_talleres', function($table) {
            $table->foreign('TALLERES_tallerID')->references('tallerID')->on('talleres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendarios_talleres');
    }
}
