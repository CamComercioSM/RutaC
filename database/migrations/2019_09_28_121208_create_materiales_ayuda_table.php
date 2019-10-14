<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialesAyudaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiales_ayuda', function (Blueprint $table) {
            $table->increments('material_ayudaID');
            $table->enum('TIPOS_MATERIALES_tipo_materialID',['Video','Documento'])->default('Documento');
            $table->string('material_ayudaNOMBRE',255);
            $table->string('material_ayudaURL',255);
            $table->string('material_ayudaCODIGO',30);
            $table->enum('material_ayudaESTADO',['Activo','Inactivo'])->default('Activo');
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
        Schema::dropIfExists('materiales_ayuda');
    }
}
