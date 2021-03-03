<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Http\Resources\VideoPreview;

class VideoSerieController extends Controller
{
    public function index(Serie $serie)
    {
        return VideoPreview::collection($serie->videos);
    }
}
