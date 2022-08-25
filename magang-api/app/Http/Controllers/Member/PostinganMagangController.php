<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Repo\Member\PostinganMagangRepo;
use Illuminate\Http\Request;

class PostinganMagangController extends Controller{

  protected $query;

  public function __construct(PostinganMagangRepo $repo)
  {
    $this->query = $repo;
  }

  public function getList(){
    $data = $this->query->getList();
    return $data;
  }
  public function getSave(Request $request){
    $data = $this->query->getSave($request);
    return $data;
  }

  public function getDeleted($postinganMagangId){
    $data = $this->query->getDeleted($postinganMagangId);
    return $data;
  }
}
