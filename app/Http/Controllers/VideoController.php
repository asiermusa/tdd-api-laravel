<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Dtos\VideoPreview;
use App\Http\Requests\VideoListRequest;

class VideoController extends Controller
{
    // Otra opcion clasica
    // public function get(string $id){
    //   return Video::find($id);
    // }

    public function index(VideoListRequest $request){

      $videos = Video::lastVideos($request->getLimit(), $request->getPage())
        ->get()
        ->mapInto(VideoPreview::class);

      return $videos;
    }


    public function get(Video $video){
      return $video;
    }
}
