<?php

namespace App\Http\Controllers\Admin;

use App\Repo\Admin\LokasiRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LokasiMagangController extends Controller{

  protected $query;

  public function __construct(LokasiRepo $repo)
  {
    $this->query = $repo;
  }
  public function getList(){
    return $this->query->getList();
  }
  public function getShowData($slug){
    return $this->query->getShowData($slug);
  }
  public function getSave(Request $req){
    return $this->query->getSave($req);
  }
  public function getDeleted($lokasiId){
    return $this->query->getDeleted($lokasiId);
  }
}
