<?php

use Illuminate\Database\Seeder;

class ServiciosCcsmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicios_ccsm')->insert(
        	[
        		'servicio_ccsmNOMBRE' => 'Formación Empresarial',
        		'servicio_ccsmURL' => 'https://www.ccsm.org.co/servicios-empresariales/servicios-ofertas-empresariales/formacion-empresarial.html'
        	]
        );

        DB::table('servicios_ccsm')->insert(
        	[
        		'servicio_ccsmNOMBRE' => 'Data Empresarial',
        		'servicio_ccsmURL' => 'https://www.ccsm.org.co/servicios-empresariales/servicios-ofertas-empresariales/infomediacion/base-de-datos-a-la-medida.html'
        	]
        );

        DB::table('servicios_ccsm')->insert(
        	[
        		'servicio_ccsmNOMBRE' => 'Crecimiento Empresarial',
        		'servicio_ccsmURL' => 'https://www.ccsm.org.co'
        	]
        );

        DB::table('servicios_ccsm')->insert(
        	[
        		'servicio_ccsmNOMBRE' => 'Internacionalización',
        		'servicio_ccsmURL' => 'https://www.ccsm.org.co'
        	]
        );

        DB::table('servicios_ccsm')->insert(
        	[
        		'servicio_ccsmNOMBRE' => 'Centro de Conciliación y Amigable Composición',
        		'servicio_ccsmURL' => 'https://www.ccsm.org.co/arbitraje-y-conciliacion/servicios-del-centro-de-arbitraje-conciliacion-y-amigable-composicion/servicio-de-arbitraje/que-es-el-arbitraje.html'
        	]
        );

        DB::table('servicios_ccsm')->insert(
        	[
        		'servicio_ccsmNOMBRE' => 'Afiliados',
        		'servicio_ccsmURL' => 'https://www.ccsm.org.co'
        	]
        );

        DB::table('servicios_ccsm')->insert(
        	[
        		'servicio_ccsmNOMBRE' => 'Formulación de proyectos',
        		'servicio_ccsmURL' => 'https://www.ccsm.org.co'
        	]
        );
    }
}
