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
    return $this->query->getList();
  }
  public function getShowData($slug){
    return $this->query->getShowData($slug);
  }
  public function getSave(Request $req){
    return $this->query->getSave($req);
  }
  public function getDeleted($kategoriId){
    return $this->query->getDeleted( $kategoriId);
  }
}
