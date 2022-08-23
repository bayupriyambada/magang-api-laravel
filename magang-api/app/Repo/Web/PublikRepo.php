<?php

namespace App\Repo\Web;

use App\Helpers\ConstantaHelpers;
use App\Helpers\ResponseHelpers;
use App\Models\Magang\FavoritModel;
use App\Models\Magang\KategoriModel;
use App\Models\Magang\LokasiModel;

class PublikRepo {

  public function getFavorit(){
    $data =FavoritModel::query()->data()->limit(15)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
  }
  public function getLokasi(){
    $data =LokasiModel::query()->data()->limit(15)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
  }
  public function getKategori(){
    $data =KategoriModel::query()->data()->limit(15)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
  }
}
