<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TiposDiagnosticosTableSeeder::class);
        $this->call(TiposMaterialesTableSeeder::class);
        $this->call(CompetenciasTableSeeder::class);
        $this->call(ServiciosCcsmTableSeeder::class);
        $this->call(DatosUsuariosTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        $this->call(SeccionesPreguntasTableSeeder::class);
        $this->call(PreguntasTableSeeder::class);
        $this->call(RespuestasTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
        $this->call(MunicipiosTableSeeder::class);
    }
}
