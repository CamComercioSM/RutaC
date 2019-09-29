<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_materiales', function (Blueprint $table) {
            $table->increments('tipo_materialID');
            $table->string('tipo_materialNOMBRE',100);
            $table->enum('tipo_materialESTADO',['Activo', 'Inactivo'])->default('Activo');
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
        Schema::dropIfExists('tipos_materiales');
    }
}
