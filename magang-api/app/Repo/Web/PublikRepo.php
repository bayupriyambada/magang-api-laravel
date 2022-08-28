<?php

namespace App\Repo\Web;

use App\Helpers\ConstantaHelpers;
use App\Helpers\ResponseHelpers;
use App\Models\Magang\CategoriesInternModel;
use App\Models\Magang\FavoritModel;
use App\Models\Magang\LocationModel;

class PublikRepo
{

  public function getFavorit()
  {
    $data = FavoritModel::query()->data()->limit(15)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
  }
  public function getLokasi()
  {
    $data = LocationModel::query()->data()->limit(15)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
  }
  public function getKategori()
  {
    $data = CategoriesInternModel::query()->data()->limit(15)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
  }
}
