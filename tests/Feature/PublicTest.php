<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicTest extends TestCase
{
    /** @test */
    function carga_vista_registro_verificar_code()
    {
        $this->assertTrue(true);
        //$this->get('registro/verificar/123')->assertStatus(200);
    }

    /** @test */
    function carga_vista_registro_actualizar_datos()
    {
        $this->assertTrue(true);
        //$this->get('registro/verificar/123')->assertStatus(200);
    }

    /** @test */
    function carga_vista_registro_nuevo()
    {
        $this->assertTrue(true);
        //$this->get('nuevo-registro')->assertStatus(200);
    }

    /** @test */
    function carga_vista_documento()
    {
        //$this->assertTrue(true);
        //$this->get('documento/xxxx')->assertStatus(200);
    }
}
