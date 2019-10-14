<?php

use Illuminate\Database\Seeder;

class TiposMaterialesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_materiales')->insert(['tipo_materialNOMBRE' => 'Vídeo']);
        DB::table('tipos_materiales')->insert(['tipo_materialNOMBRE' => 'Documento']);
    }
}
