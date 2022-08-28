<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repo\Admin\CategoriesInternRepo;
use Illuminate\Http\Request;

class CategoriesInternController extends Controller
{

  protected $query;
  public function __construct(CategoriesInternRepo $categories)
  {
    $this->query = $categories;
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

  // get data delete and trash permanent

  public function getDataTrash()
  {
    return $this->query->getCategoryTrash();
  }
  public function getDeletePermanent($categoryId)
  {
    return $this->query->getCategoryDeletePermanent($categoryId);
  }
}
