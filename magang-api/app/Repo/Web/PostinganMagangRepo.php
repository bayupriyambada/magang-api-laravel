<?php

namespace App\Repo\Web;

use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;
use App\Http\Resources\PostinganMagangResource;
use App\Models\Magang\PostinganMagangModel;

class PostinganMagangRepo {
  public function getData(){
    $data = PostinganMagangResource::collection(PostinganMagangModel::get());
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
  }

  public function getSlug($slug){
    try {
    $data = PostinganMagangModel::query()
    ->slug($slug)
    ->first()->makeHidden(['diubah_pada', 'dihapus_pada']);
    if(is_null($data)){
      return ResponseHelpers::Success(404, ConstantaHelpers::DATA_NOT_FOUND, []);
    }
      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
