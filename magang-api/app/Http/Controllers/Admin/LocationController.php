<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repo\Admin\LocationRepo;
use Illuminate\Http\Request;

class LocationController extends Controller
{

  protected $query;

  public function __construct(LocationRepo $repo)
  {
    $this->query = $repo;
  }
  public function getList()
  {
    return $this->query->getAllLocation();
  }
  public function getSave(Request $req)
  {
    return $this->query->getSaveLocation($req);
  }
  public function getDeleted($lokasiId)
  {
    return $this->query->getDeleteLocation($lokasiId);
  }
}
