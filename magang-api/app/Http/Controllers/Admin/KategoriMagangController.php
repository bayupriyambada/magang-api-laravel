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
  public function getShowData($slug){
    $data = $this->query->getShowData($slug);
    return $data;
  }
  public function getSave(Request $req){
    $data = $this->query->getSave($req->only(['uuid', 'kategori', 'status']));
    return $data;
  }
  public function getDeleted($uuid){
    $data = $this->query->getDeleted(['uuid', $uuid]);
    return $data;
  }
}
