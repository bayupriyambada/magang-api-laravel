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
    $data =$this->query->getList();
    return $data;
  }
  public function getShowData($slug){
    $data = $this->query->getShowData($slug);
    return $data;
  }
  public function getSave(Request $req){
    $data = $this->query->getSave($req->only(['uuid','lokasi','status']));
    return $data;
  }
  public function getDeleted($uuid){
    $data = $this->query->getDeleted(['uuid' ,$uuid]);
    return $data;
  }
}
