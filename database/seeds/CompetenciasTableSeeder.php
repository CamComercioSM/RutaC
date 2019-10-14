<?php

use Illuminate\Database\Seeder;

class CompetenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('competencias')->insert([
            'competenciaNOMBRE' => 'Ser'
        ]);
        DB::table('competencias')->insert([
            'competenciaNOMBRE' => 'Creatividad/Inovación'
        ]);
        DB::table('competencias')->insert([
            'competenciaNOMBRE' => 'Amplitud perceptual'
        ]);
        DB::table('competencias')->insert([
            'competenciaNOMBRE' => 'Pensamiento sistémico'
        ]);
        DB::table('competencias')->insert([
            'competenciaNOMBRE' => 'Liderazgo'
        ]);
        DB::table('competencias')->insert([
            'competenciaNOMBRE' => 'Orientación a mercado'
        ]);
        DB::table('competencias')->insert([
            'competenciaNOMBRE' => 'Orientación al logro'
        ]);
    }
}
