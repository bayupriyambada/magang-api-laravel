<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Repo\Admin\Dashboard\DashboardRepo;

class DashboardController extends Controller{
  protected $dashboard;

  public function __construct(DashboardRepo $repo)
  {
    $this->dashboard = $repo;
  }

  public function getDashboard(){
    $data = $this->dashboard->getDashboard();
    return $data;
  }
}
