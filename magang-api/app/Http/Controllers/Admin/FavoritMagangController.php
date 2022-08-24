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
  public function getShowData($slug){
    $data = $this->query->getShowData( [
      'slug' => $slug
    ]);
    return $data;
  }

  public function getSave(Request $req){
    $data = $this->query->getSave($req->only(['favorite_magang_id' ,'favorit']));
    return $data;
  }

  public function getDeleted($favoritId){
    $data = $this->query->getDeleted($favoritId);
    return $data;
  }
}
