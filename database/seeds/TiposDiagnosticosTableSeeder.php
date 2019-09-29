<?php

use Illuminate\Database\Seeder;

class TiposDiagnosticosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_diagnosticos')->insert(['tipo_diagnosticoNOMBRE' => 'EMPRENDIMIENTO']);
        DB::table('tipos_diagnosticos')->insert(['tipo_diagnosticoNOMBRE' => 'EMPRESA']);
        DB::table('tipos_diagnosticos')->insert(['tipo_diagnosticoNOMBRE' => 'EXPORTADOR']);
    }
}
