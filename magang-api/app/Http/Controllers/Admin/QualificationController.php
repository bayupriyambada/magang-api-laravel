<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repo\Admin\QualificationRepo;
use Illuminate\Http\Request;

class QualificationController extends Controller
{

  protected $query;
  public function __construct(QualificationRepo $repo)
  {
    $this->query = $repo;
  }
  public function getList()
  {
    return $this->query->getAllQualification();
  }
  public function getSave(Request $req)
  {
    return $this->query->getSaveQualification($req);
  }
  public function getDeleted($qualificationId)
  {
    return $this->query->getDeleteQualification($qualificationId);
  }

  // get data delete and trash permanent

  public function getDataTrash()
  {
    return $this->query->getQualificationTrash();
  }
  public function getDeletePermanent($qualificationId)
  {
    return $this->query->getQualificationDeletePermanent($qualificationId);
  }
}
