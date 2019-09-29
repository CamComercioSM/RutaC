<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmprendimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprendimientos', function (Blueprint $table) {
            $table->increments('emprendimientoID');
            $table->integer('USUARIOS_usuarioID')->unsigned();
            $table->string('emprendimientoNOMBRE',255);
            $table->string('emprendimientoDESCRIPCION',255);
            $table->date('emprendimientoINICIOACTIVIDADES')->nullable();
            $table->decimal('emprendimientoINGRESOS', 20, 2)->nullable();
            $table->decimal('emprendimientoREMUNERACION', 20, 2)->nullable();
            $table->enum('emprendimientoESTADO',['Activo', 'En Proceso', 'Finalizado', 'Eliminado', 'Descartado', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('emprendimientos', function($table) {
            $table->foreign('USUARIOS_usuarioID')->references('usuarioID')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emprendimientos');
    }
}
