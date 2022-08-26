<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repo\Web\PostinganMagangRepo;

class PostinganMagangController extends Controller{

  protected $query;

  public function __construct(PostinganMagangRepo $repo)
  {
    $this->query =$repo;
  }
  public function getAll(){
    $data = $this->query->getAllPostsIntern();
    return $data;
  }
  public function getSlug($slug){
    $data = $this->query->getSlugPostsIntern($slug);
    return $data;
  }
}
