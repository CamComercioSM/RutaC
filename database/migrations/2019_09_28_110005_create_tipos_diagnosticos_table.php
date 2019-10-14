<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposDiagnosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_diagnosticos', function (Blueprint $table) {
            $table->increments('tipo_diagnosticoID');
            $table->string('tipo_diagnosticoNOMBRE',100);
            $table->enum('tipo_diagnosticoESTADO',['Activo', 'Inactivo'])->default('Activo');
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
        Schema::dropIfExists('tipos_diagnosticos');
    }
}
