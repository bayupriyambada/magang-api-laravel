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

  public function getSave(Request $req){
    $data = [
      'uuid' => $req->input('uuid'),
      'lokasi' => $req->input('lokasi'),
      'status' => $req->input('status'),
    ];

    $data = $this->query->getSave($req);
    return $data;
  }

  public function getDeleted($uuid){
    $data = [
      'uuid' => $uuid
    ];
    $data = $this->query->getDeleted($data);
    return $data;
  }
}
