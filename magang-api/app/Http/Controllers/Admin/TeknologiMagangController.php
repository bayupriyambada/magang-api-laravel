<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repo\Admin\TeknologiRepo;
use Illuminate\Http\Request;

class TeknologiMagangController extends Controller{
 
  protected $query;
  public function __construct(TeknologiRepo $repo){
    $this->query = $repo;
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
    $data = $this->query->getSave($req);
    return $data;
  }
  public function getDeleted($kategoriId){
    $data = $this->query->getDeleted( $kategoriId);
    return $data;
  }
}
