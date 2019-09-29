<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->increments('rutaID');
            $table->integer('DIAGNOSTICOS_diagnosticoID')->unsigned();
            $table->string('rutaNOMBRE',255);
            $table->decimal('rutaCUMPLIMIENTO', 10, 2)->nullable();
            $table->enum('rutaESTADO',['Activo', 'En Proceso','Finalizado','Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('rutas', function($table) {
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
        Schema::dropIfExists('rutas');
    }
}
