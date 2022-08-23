<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repo\Admin\KategoriRepo;
use Illuminate\Http\Request;

class KategoriMagangController extends Controller{
 
  protected $query;
  public function __construct(KategoriRepo $kategori){
    $this->query = $kategori;
  }

  public function getList(){
    $data = $this->query->getList();
    return $data;
  }

  public function getSave(Request $req){
    $data = [
      'uuid' => $req->input('uuid'),
      'kategori' => $req->input('kategori'),
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
