<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repo\Web\PublikRepo;

class PublikController extends Controller{
  
  protected $query;

  public function __construct(PublikRepo $repo)
  {
    $this->query  = $repo;
  }
  public function getFavorit(){
    $data = $this->query->getFavorit();
    return $data;
  }
  
  public function getKategori(){
    $data = $this->query->getKategori();
    return $data;
  }

  public function getLokasi(){
    $data = $this->query->getLokasi();
    return $data;
  }
}
