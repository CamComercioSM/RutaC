<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_usuarios', function (Blueprint $table) {
            $table->increments('dato_usuarioID');
            $table->string('dato_usuarioNOMBRE_COMPLETO',255);
            $table->string('dato_usuarioNOMBRES',100)->nullable();
            $table->string('dato_usuarioAPELLIDOS',100)->nullable();
            $table->string('dato_usuarioTIPO_IDENTIFICACION',5);
            $table->string('dato_usuarioIDENTIFICACION',45);
            $table->string('dato_usuarioDIRECCION',255)->nullable();
            $table->string('dato_usuarioDEPARTAMENTO_RESIDENCIA',100)->nullable();
            $table->string('dato_usuarioMUNICIPIO_RESIDENCIA',100)->nullable();
            $table->string('dato_usuarioTELEFONO',45)->nullable();
            $table->enum('dato_usuarioSEXO',['Mujer', 'Hombre','Prefiero no decirlo'])->nullable();
            $table->date('dato_usuarioFECHA_NACIMIENTO')->nullable();
            $table->string('dato_usuarioDEPARTAMENTO_NACIMIENTO',100)->nullable();
            $table->string('dato_usuarioMUNICIPIO_NACIMIENTO',100)->nullable();
            $table->string('dato_usuarioNIVEL_ESTUDIO',100)->nullable();
            $table->string('dato_usuarioPROFESION_OCUPACION',255)->nullable();
            $table->string('dato_usuarioCARGO',100)->nullable();
            $table->string('dato_usuarioREMUNERACION',100)->nullable();
            $table->string('dato_usuarioGRUPO_ETNICO',100)->nullable();
            $table->string('dato_usuarioDISCAPACIDAD',20)->nullable();
            $table->string('dato_usuarioIDIOMAS',100)->nullable();
            $table->tinyInteger('dato_usuarioACEPTACIONTERMINOS');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_usuarios');
    }
}
