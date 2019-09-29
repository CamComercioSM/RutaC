<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('empresaID');
            $table->integer('USUARIOS_usuarioID')->unsigned();
            $table->string('empresaNIT',45);
            $table->string('empresaMATRICULA_MERCANTIL',100)->nullable();
            $table->string('empresaRAZON_SOCIAL',255);
            $table->string('empresaORGANIZACION_JURIDICA',45)->nullable();
            $table->date('empresaFECHA_CONSTITUCION')->nullable();
            $table->string('empresaDEPARTAMENTO_EMPRESA',100)->nullable();
            $table->string('empresaMUNICIPIO_EMPRESA',100)->nullable();
            $table->string('empresaDIRECCION_FISICA',255)->nullable();
            $table->string('empresaEMPLEADOS_FIJOS',50)->nullable();
            $table->string('empresaEMPLEADOS_TEMPORALES',50)->nullable();
            $table->string('empresaRANGOS_ACTIVOS',100)->nullable();
            $table->string('empresaCORREO_ELECTRONICO',255)->nullable();
            $table->string('empresaSITIO_WEB',255)->nullable();
            $table->text('empresaREDES_SOCIALES')->nullable();
            $table->text('empresaCONTACTO_TALENTO_HUMANO')->nullable();
            $table->text('empresaCONTACTO_COMERCIAL')->nullable();
            $table->enum('empresaESTADO',['Activo', 'En Proceso', 'Finalizado', 'Eliminado', 'Descartado', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::table('empresas', function($table) {
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
        Schema::dropIfExists('empresas');
    }
}
