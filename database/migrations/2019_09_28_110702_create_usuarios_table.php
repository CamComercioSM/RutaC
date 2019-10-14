<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('usuarioID');
            $table->integer('dato_usuarioID')->unsigned()->nullable();
            $table->string('usuarioEMAIL',100);
            $table->string('password',255);
            $table->string('remember_token',100)->nullable();
            $table->enum('perfilCompleto',['Si', 'No'])->nullable();
            $table->enum('usuarioESTADO',['Activo', 'Inactivo'])->default('Activo');
            $table->string('password_generated',255)->nullable();
            $table->enum('tipoUsuario',['Usuario', 'Admin'])->default('Usuario');
            $table->tinyInteger('confirmed');
            $table->string('confirmation_code',255)->nullable();
            $table->string('update_code',255)->nullable();
            $table->timestamps();
        });

        Schema::table('usuarios', function($table) {
            $table->foreign('dato_usuarioID')->references('dato_usuarioID')->on('datos_usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
