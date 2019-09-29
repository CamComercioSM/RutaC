<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->increments('id_municipio');
            $table->string('municipio',255);
            $table->enum('estado',['Activo', 'Inactivo'])->default('Activo');
            $table->integer('departamento_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('municipios', function($table) {
            $table->foreign('departamento_id')->references('id_departamento')->on('departamentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipios');
    }
}
