<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Dtos\VideoPreview;

class VideoController extends Controller
{
    // Otra opcion clasica
    // public function get(string $id){
    //   return Video::find($id);
    // }

    public function index(){
      $videos = Video::orderBy('created_at', 'DESC')->get()
        ->mapInto(VideoPreview::class);

      return $videos;
    }


    public function get(Video $video){
      return $video;
    }
}
