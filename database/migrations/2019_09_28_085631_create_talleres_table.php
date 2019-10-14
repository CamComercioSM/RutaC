<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalleresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talleres', function (Blueprint $table) {
            $table->increments('tallerID');
            $table->string('tallerNOMBRE',255);
            $table->text('tallerURL');
            $table->enum('tallerESTADO',['Activo', 'Inactivo'])->default('Activo');
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
        Schema::dropIfExists('talleres');
    }
}
