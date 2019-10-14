<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados_preguntas', function (Blueprint $table) {
            $table->increments('resultado_preguntaID');
            $table->integer('RES_SECCION_resultado_seccionID')->unsigned();
            $table->integer('resultado_preguntaPREGUNTAID')->unsigned();
            $table->string('resultado_preguntaENUNCIADO_PREGUNTA',255);
            $table->string('resultado_preguntaPRESENTACION',255)->nullable();
            $table->string('resultado_preguntaCUMPLIMIENTO',5)->nullable();
            $table->string('resultado_preguntaCOMPETENCIA',100)->nullable();
            $table->text('resultado_preguntaFEEDBACK')->nullable();
            $table->enum('resultado_preguntaESTADO',['Respondida', 'No Respondida'])->default('No Respondida');
            $table->timestamps();
        });

        Schema::table('resultados_preguntas', function($table) {
            $table->foreign('RES_SECCION_resultado_seccionID')->references('resultado_seccionID')->on('resultados_seccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultados_preguntas');
    }
}
