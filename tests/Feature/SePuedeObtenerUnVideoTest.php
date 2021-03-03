<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Video;

class SePuedeObtenerUnVideoTest extends TestCase
{

    //trait para refrescar la bd de phpunit.xml (en memoria)
    use RefreshDatabase;

    public function testSePuedeObtenerUnVideoPorSuId()
    {
      // crear el escenario
      //
      // persistir video en base de datos
      $video = Video::factory()->create();

      //  llamar a la Api para pedir el video
      $response = $this->get(
        sprintf(
          '/api/videos/%s',
          $video->id
        )
      );
      //  comprobar que devuelve el video
      $response->assertJsonFragment($video->toArray());
    }
}
