<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->increments('diagnosticoID');
            $table->integer('EMPRESAS_empresaID')->unsigned()->nullable();
            $table->integer('EMPRENDIMIENTOS_emprendimientoID')->unsigned()->nullable();
            $table->integer('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->unsigned();
            $table->string('diagnosticoREALIZADO_POR',255);
            $table->date('diagnosticoFECHA');
            $table->string('diagnosticoNOMBRE',255);
            $table->decimal('diagnosticoRESULTADO', 10, 4)->nullable();
            $table->string('diagnosticoNIVEL',20)->nullable();
            $table->text('diagnosticoMENSAJE')->nullable();
            $table->enum('diagnosticoESTADO',['Activo', 'En Proceso','Finalizado','Eliminado','Descartado','Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('diagnosticos', function($table) {
            $table->foreign('EMPRENDIMIENTOS_emprendimientoID')->references('emprendimientoID')->on('emprendimientos');
            $table->foreign('EMPRESAS_empresaID')->references('empresaID')->on('empresas');
            $table->foreign('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->references('tipo_diagnosticoID')->on('tipos_diagnosticos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnosticos');
    }
}
