<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Video;
use App\Dtos\VideoPreview;
use Carbon\Carbon;

class SePuedeObtenerUnListadoDeVideosTest extends TestCase
{

    use RefreshDatabase;
    // Para debug de errores lanzados por execpciones
    // $this->withoutExceptionHandling();

    public function testSePuedeObtenerListadoDeVideos(){

      $videos = Video::factory(2)->create();

      $response = $this->getJson('/api/videos')
        ->assertOk()
        ->assertJsonCount(2);
    }

    public function testElPayloadContienLosVideosEnElSistema(){

      $videoId = 1234;
      $videoThumbnail = 'http://miimagen.jpg';

      $video = Video::factory([
        'id' => $videoId,
        'thumbnail' => $videoThumbnail
      ])->create();

      // $this->getJson('/api/videos')
      //   ->assertJson($videos->toArray());

      $response = $this->getJson('/api/videos')
        ->assertExactJson([
          [
            'id' => $videoId,
            'thumbnail' => $videoThumbnail
          ]
        ]);
    }

    public function testLosVideosEstanOrdenadosDeNuevosAAntiguos(){

      $videoPast = Video::factory()->create([
        'created_at' => Carbon::now()->subDays(30)
      ]);

      $videoToday = Video::factory()->create([
        'created_at' => Carbon::now()
      ]);

      $videoYesterday = Video::factory()->create([
        'created_at' => Carbon::yesterday()
      ]);

      $response = $this->getJson('/api/videos')
        ->assertJsonPath('0.id', $videoToday->id)
        ->assertJsonPath('1.id', $videoYesterday->id)
        ->assertJsonPath('2.id', $videoPast->id);

      // OLD MODE
      // [$videoOne, $videoTwo, $videoThree] = $response->json();
      //
      // //Today
      // $this->assertEquals($videoOne['id'], $videoToday->id);
      // //Yesterday
      // $this->assertEquals($videoTwo['id'], $videoYesterday->id);
      // //A month ago
      // $this->assertEquals($videoThree['id'], $videoPast->id);
    }
}
