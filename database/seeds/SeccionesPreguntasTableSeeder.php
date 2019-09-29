<?php

use Illuminate\Database\Seeder;

class SeccionesPreguntasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '1','seccion_preguntaNOMBRE' => 'Habilidades como emprendedor','seccion_preguntaPESO' => '3']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '1','seccion_preguntaNOMBRE' => 'Evaluación de la idea de negocio','seccion_preguntaPESO' => '3']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '1','seccion_preguntaNOMBRE' => 'Conocimiento del mercado','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Habilidades como empresario','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Estrategia/Administración','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Mercadeo/Ventas','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Finanzas/Contabilidad','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Talento Humano','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Producción/Operaciones','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Innovación','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Internacionalización','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '2','seccion_preguntaNOMBRE' => 'Aspectos legales','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '3','seccion_preguntaNOMBRE' => 'Condiciones de la Empresa','seccion_preguntaPESO' => '2']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '3','seccion_preguntaNOMBRE' => 'Herramientas de Comunicación y Promoción','seccion_preguntaPESO' => '2']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '3','seccion_preguntaNOMBRE' => 'Internacionalización','seccion_preguntaPESO' => '1']);
		DB::table('secciones_preguntas')->insert(['TIPO_DIAGNOSTICOS_tipo_diagnosticoID' => '3','seccion_preguntaNOMBRE' => 'Productos y/o Servicios','seccion_preguntaPESO' => '3']);

    }
}
