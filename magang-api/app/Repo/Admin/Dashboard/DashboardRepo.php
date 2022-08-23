<?php

namespace App\Repo\Admin\Dashboard;

use App\Helpers\ConstantaHelpers;
use App\Helpers\ResponseHelpers;
use App\Models\Magang\FavoritModel;
use App\Models\Magang\KategoriModel;
use App\Models\Magang\LokasiModel;
use Illuminate\Http\Request;

class DashboardRepo {
  
  public function getDashboard(){
    $favorit = FavoritModel::query()->count();
    $lokasi = LokasiModel::query()->count();
    $kategori = KategoriModel::query()->count();
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA,
    [
      'kategori' => $kategori,
      'lokasi' => $lokasi,
      'favorit' => $favorit,
    ]);
  }
}
