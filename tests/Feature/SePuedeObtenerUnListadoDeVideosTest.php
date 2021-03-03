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

    public function testSepuedeLimitarElNumeroDeVideosAObtener(){
        Video::factory(5)->create();
        $this->getJson('/api/videos?limit=3')
          ->assertJsonCount(3);
    }

    public function testPorDefectoSoloEnvia_30Videos() {
      Video::factory(20)->create();
      $this->getJson('/api/videos')
        ->assertJsonCount(10);
    }


    // data provider
    public function invalidLimitProvider()
    {
      return [
        'El límite inferior es 1' => [3, '-1'],
        'El límite es de 50 videos' => [51, '51'],
        'No se puede pasar un limite como string' => [4, 'unstring']
      ];
    }

    /**
     * @dataProvider invalidLimitProvider
     */
    public function testDevuelveUnprocessableSiHayErrorEnElLimite($numberOfVideos, $limit)
    {
        Video::factory($numberOfVideos)->create();
        $this->getJson(
          sprintf('/api/videos?limit=%s', $limit)
        )
        ->assertStatus(422);
    }

    public function testPodemosPaginarLosVideos()
    {
        // crear 9 videos
        Video::factory(9)->create();
        // Pedir que me de pagina 2 limitando a 5 $videos
        $this->getJson('/api/videos?limit=5&page=2')
          ->assertJsonCount(4);
    }

    public function testPaginacionPorDefectoPaginaPrimera()
    {
        // crear 9 videos
        Video::factory(9)->create();
        // Pedir que me de pagina 2 limitando a 5 $videos
        $this->getJson('/api/videos?limit=5')
          ->assertJsonCount(5);
    }


    // data provider
    public function invalidPagesProvider()
    {
      return [
        'No se puede pasar un string como pagina' => ['unstring'],
        'La página no puede ser menor que 1' => [0]
      ];
    }

    /**
     * @dataProvider invalidPagesProvider
     */
    public function testDevuelveCeroVideosCuandoLaPaginaNoExiste($invalidPage)
    {
        // crear 9 videos
        Video::factory(9)->create();
        // Pedir que me de pagina 2 limitando a 5 $videos
        $this->getJson(sprintf('/api/videos?page=%s', $invalidPage))
          ->assertStatus(422);
    }
}
