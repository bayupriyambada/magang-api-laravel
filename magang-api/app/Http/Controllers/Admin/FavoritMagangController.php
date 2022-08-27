<?php

namespace App\Http\Controllers\Admin;

use App\Repo\Admin\FavoritRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoritMagangController extends Controller
{

  protected $query;

  public function __construct(FavoritRepo $repo)
  {
    $this->query = $repo;
  }

  public function getList()
  {
    return $this->query->getAllFavorite();
  }

  public function getShowData($slug)
  {
    return $this->query->getSlugFavorite($slug);
  }

  public function getSave(Request $req)
  {
    return $this->query->getSaveFavorite($req);
  }

  public function getDeleted($favoritId)
  {
    return $this->query->getDeleteFavorite($favoritId);
  }
}
