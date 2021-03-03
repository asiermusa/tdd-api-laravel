<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Http\Resources\SeriePreview;

class SerieController extends Controller
{
    public function index()
    {
        return SeriePreview::collection(Serie::all());
    }
}
