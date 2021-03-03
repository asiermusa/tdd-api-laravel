<?php

namespace App\Dtos;

use JsonSerializable;
use App\Models\Video;

class VideoPreview implements JsonSerializable {

  private Video $video;

  public function __construct(Video $video) {
    $this->video = $video;
  }

  public function JsonSerialize(): array
  {
    return [
        'id' => $this->video->id,
        'thumbnail' => $this->video->thumbnail
    ];
  }
}
