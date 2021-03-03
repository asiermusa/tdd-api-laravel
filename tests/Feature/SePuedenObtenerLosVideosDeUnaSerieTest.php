<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Video;
use App\Models\Serie;

class SePuedenObtenerLosVideosDeUnaSerieTest extends TestCase
{
    use RefreshDatabase;

    public function testSePuedenObtenerLosVideosDeUnaSerie()
    {
        // crear un video no asociado a serie
        Video::factory()->create();

        // crear una serie
        $serie = Serie::factory()->create();

        // crear 2 videos y asociarlos a la Serie
        $serie->videos()->attach(
            Video::factory(2)->create()->pluck('id')->toArray()
        );

        $this->getJson(sprintf('/api/series/%s/videos', $serie->id))
          ->assertOk()
          ->assertJsonCount(2);
    }

    public function testElContenidoDeLosVideosEsElCorrecto()
    {
      $video = Video::factory()->create();
      $serie = Serie::factory()->create();
      $serie->videos()->attach($video->id);

      $this->getJson(sprintf('/api/series/%s/videos', $serie->id))
        ->assertOk()
        ->assertExactJson([
          [
            'id' => $video->id,
            'thumbnail' => $video->thumbnail
          ]
        ]);
    }
}
