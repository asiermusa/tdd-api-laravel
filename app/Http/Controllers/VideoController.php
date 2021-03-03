<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Resources\VideoPreview;
use App\Http\Requests\VideoListRequest;

class VideoController extends Controller
{
    // Otra opcion clasica
    // public function get(string $id){
    //   return Video::find($id);
    // }

    public function index(VideoListRequest $request){

      // Mendiante uso de Dto (Data Transfer Operations)
      // $videos = Video::lastVideos($request->getLimit(), $request->getPage())
      //   ->get()
      //   ->mapInto(VideoPreview::class);

      return VideoPreview::collection(Video::lastVideos($request->getLimit(), $request->getPage())->get());
    }


    public function get(Video $video){
      return $video;
    }
}
