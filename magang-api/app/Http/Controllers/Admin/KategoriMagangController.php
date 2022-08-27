<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repo\Admin\KategoriRepo;
use Illuminate\Http\Request;

class KategoriMagangController extends Controller
{

  protected $query;
  public function __construct(KategoriRepo $kategori)
  {
    $this->query = $kategori;
  }
  public function getList()
  {
    return $this->query->getAllCategory();
  }
  public function getShowData($slug)
  {
    return $this->query->getCategorySlug($slug);
  }
  public function getSave(Request $req)
  {
    return $this->query->getCategorySave($req);
  }
  public function getDeleted($categoryId)
  {
    return $this->query->getCategoryDelete($categoryId);
  }
}
