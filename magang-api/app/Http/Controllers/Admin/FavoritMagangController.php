<?php

namespace App\Http\Controllers\Admin;

use App\Repo\Admin\FavoritRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoritMagangController extends Controller {

  protected $query;

  public function __construct(FavoritRepo $repo)
  {
   $this->query = $repo;
  }

  public function getList(){
    $data = $this->query->getList();
    return $data;
  }

  public function getSave(Request $req){
    $data = [
      'uuid' => $req->input('uuid'),
      'favorit' => $req->input('favorit'),
    ];
    $data = $this->query->getSave($req);
    return $data;
  }

  public function getDeleted($uuid){
    $data = $this->query->getDeleted($uuid);
    return $data;
  }
}
