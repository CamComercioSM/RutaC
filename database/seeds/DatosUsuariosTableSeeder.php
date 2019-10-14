<?php

use Illuminate\Database\Seeder;

class DatosUsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('datos_usuarios')->insert(
        	[
        		'dato_usuarioNOMBRE_COMPLETO' => 'Admnistrador Ruta C',
        		'dato_usuarioNOMBRES' => 'Administrador',
        		'dato_usuarioAPELLIDOS' => 'Ruta C',
        		'dato_usuarioTIPO_IDENTIFICACION' => 'CC',
        		'dato_usuarioIDENTIFICACION' => '12345678900',
        		'dato_usuarioACEPTACIONTERMINOS' => '1'
        	]
        );
    }
}
