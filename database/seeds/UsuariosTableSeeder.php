<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert(
        	[
        		'dato_usuarioID' => '1',
        		'usuarioEMAIL' => 'admin@rutac.com',
        		'password' => bcrypt('123456'),
        		'perfilCompleto' => 'Si',
        		'tipoUsuario' => 'Admin',
        		'confirmed' => '1'
        	]
        );
    }
}
