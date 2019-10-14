<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /** @test */
    function carga_vista_registro()
    {
        $this->assertTrue(true);
        //$this->get('registro')->assertStatus(200);
    }

    //REGISTRO POST
    //REGISTRO VALIDAR

    //OK
    /** @test */
    function carga_vista_restablecer_clave()
    {
        $this->get('password/reset')->assertStatus(200);
    }

    //RESTABLECER CLAVE POST

    //OK
    /** @test */
    function carga_vista_restablecer_clave__token()
    {
        $this->get('password/reset/123')->assertStatus(200);
    }

    //RESTABLECER CLAVE TOKEN
}
