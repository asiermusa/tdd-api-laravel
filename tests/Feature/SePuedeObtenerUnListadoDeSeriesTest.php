<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Serie;

class SePuedeObtenerUnListadoDeSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function testSePuedeObtenerUnListadoDeSeries()
    {
        $series = Serie::factory(2)->create();
        $this->getJson('/api/series')
          ->assertOk()
          ->assertJsonCount(2);
    }

    public function testElPreviewDeUnaSerieTieneElFormatoCorrecto()
    {
      $id = 12345;
      $title = 'My video title';
      $thumbnail = 'https://mi_imagen.jpg';
      $excerpt = 'Resumen...';

      Serie::factory([
        'id' => $id,
        'title' => $title,
        'excerpt' => $excerpt,
        'thumbnail' => $thumbnail,
      ])->create();

      $this->getJson('/api/series')
        ->assertExactJson([
          [
            'id' => $id,
            'title' => $title,
            'excerpt' => $excerpt,
            'thumbnail' => $thumbnail,
          ]
        ]);
    }
}
