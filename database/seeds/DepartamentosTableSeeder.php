<?php

use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->insert(['id_departamento' => '5','departamento' => 'ANTIOQUÍA']);
        DB::table('departamentos')->insert(['id_departamento' => '8','departamento' => 'ATLÁNTICO']);
        DB::table('departamentos')->insert(['id_departamento' => '11','departamento' => 'BOGOTÁ, D.C.']);
		DB::table('departamentos')->insert(['id_departamento' => '13','departamento' => 'BOLÍVAR']);
		DB::table('departamentos')->insert(['id_departamento' => '15','departamento' => 'BOYACÁ']);
		DB::table('departamentos')->insert(['id_departamento' => '17','departamento' => 'CALDAS']);
		DB::table('departamentos')->insert(['id_departamento' => '18','departamento' => 'CAQUETÁ']);
		DB::table('departamentos')->insert(['id_departamento' => '19','departamento' => 'CAUCA']);
		DB::table('departamentos')->insert(['id_departamento' => '20','departamento' => 'CESAR']);
		DB::table('departamentos')->insert(['id_departamento' => '23','departamento' => 'CÓRDOBA']);
		DB::table('departamentos')->insert(['id_departamento' => '25','departamento' => 'CUNDINAMARCA']);
		DB::table('departamentos')->insert(['id_departamento' => '27','departamento' => 'CHOCÓ']);
		DB::table('departamentos')->insert(['id_departamento' => '41','departamento' => 'HUILA']);
		DB::table('departamentos')->insert(['id_departamento' => '44','departamento' => 'LA GUAJIRA']);
		DB::table('departamentos')->insert(['id_departamento' => '47','departamento' => 'MAGDALENA']);
		DB::table('departamentos')->insert(['id_departamento' => '50','departamento' => 'META']);
		DB::table('departamentos')->insert(['id_departamento' => '52','departamento' => 'NARIÑO']);
		DB::table('departamentos')->insert(['id_departamento' => '54','departamento' => 'NORTE DE SANTANDER']);
		DB::table('departamentos')->insert(['id_departamento' => '63','departamento' => 'QUINDIO']);
		DB::table('departamentos')->insert(['id_departamento' => '66','departamento' => 'RISARALDA']);
		DB::table('departamentos')->insert(['id_departamento' => '68','departamento' => 'SANTANDER']);
		DB::table('departamentos')->insert(['id_departamento' => '70','departamento' => 'SUCRE']);
		DB::table('departamentos')->insert(['id_departamento' => '73','departamento' => 'TOLIMA']);
		DB::table('departamentos')->insert(['id_departamento' => '76','departamento' => 'VALLE DEL CAUCA']);
		DB::table('departamentos')->insert(['id_departamento' => '81','departamento' => 'ARAUCA']);
		DB::table('departamentos')->insert(['id_departamento' => '85','departamento' => 'CASANARE']);
		DB::table('departamentos')->insert(['id_departamento' => '86','departamento' => 'PUTUMAYO']);
		DB::table('departamentos')->insert(['id_departamento' => '88','departamento' => 'SAN ANDRÉS, PROVIDENCIA Y SANTA CATALINA']);
		DB::table('departamentos')->insert(['id_departamento' => '91','departamento' => 'AMAZONAS']);
		DB::table('departamentos')->insert(['id_departamento' => '94','departamento' => 'GUAINÍA']);
		DB::table('departamentos')->insert(['id_departamento' => '95','departamento' => 'GUAVIARE']);
		DB::table('departamentos')->insert(['id_departamento' => '97','departamento' => 'VAUPÉS']);
		DB::table('departamentos')->insert(['id_departamento' => '99','departamento' => 'VICHADA']);

    }
}
