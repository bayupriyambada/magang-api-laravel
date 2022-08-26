<?php

namespace App\Repo\Web;

use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\PostinganMagangModel;

class PostinganMagangRepo
{

  public function getAllPostsIntern()
  {
    $posts = PostinganMagangModel::query()
      ->search()->data()->get();
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $posts);
  }

  public function getSlugPostsIntern($slug)
  {
    try {
      $postsSlug = PostinganMagangModel::query()
        ->slug($slug)
        ->first()
        ->makeHidden(['diubah_pada', 'dihapus_pada']);
      if (is_null($slug)) {
        return ResponseHelpers::Success(404, ConstantaHelpers::DATA_NOT_FOUND, []);
      }
      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $postsSlug);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
