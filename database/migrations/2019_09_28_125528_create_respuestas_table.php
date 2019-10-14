<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->increments('respuestaID');
            $table->integer('PREGUNTAS_preguntaID')->unsigned();
            $table->string('respuestaPRESENTACION',255);
            $table->decimal('respuestaCUMPLIMIENTO', 10, 2);
            $table->text('respuestaFEEDBACK')->nullable();
            $table->enum('respuestaESTADO',['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('respuestas', function($table) {
            $table->foreign('PREGUNTAS_preguntaID')->references('preguntaID')->on('preguntas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
}
