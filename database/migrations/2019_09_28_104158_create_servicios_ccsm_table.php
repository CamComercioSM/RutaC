<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosCcsmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_ccsm', function (Blueprint $table) {
            $table->increments('servicio_ccsmID');
            $table->string('servicio_ccsmNOMBRE',255);
            $table->text('servicio_ccsmURL');
            $table->enum('servicio_ccsmESTADO',['Activo', 'Inactivo'])->default('Activo');
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
        Schema::dropIfExists('servicios_ccsm');
    }
}
