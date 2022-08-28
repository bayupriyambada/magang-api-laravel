<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\LocationModel;

class LocationRepo
{

  public function getAllLocation()
  {
    try {
      $s = request()->s;
      $lokasi = LocationModel::query()->data()
        ->when($s, function ($data) use ($s) {
          $data = $data->where('location', 'ILIKE', '%' . $s . '%')
            ->orWhere('slug', 'ILIKE', '%' . $s . '%');
        })
        ->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $lokasi);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getSaveLocation($params)
  {

    try {
      $location = isset($params['location']) ? $params['location'] : '';
      if (strlen($location) == 0) {
        return ConditionHelpers::condition404('Location ' . ConstantaHelpers::DATA_EMPTY);
      }

      $locationId = isset($params['location_id']) ? $params['location_id'] : '';
      if (strlen($locationId) == 0) {
        $save = new LocationModel();
        $save->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      } else {
        $save = LocationModel::query()->find($locationId);
        $save->diubah_pada = FormatHelpers::IndonesiaFormatData();

        if (is_null($save)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if (!is_null($save->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }

      $save->location = Str::ucfirst($location);
      $save->slug = Str::slug($location);
      $save->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $save);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getDeleteLocation($params)
  {

    try {
      $locationId = isset($params['location_id']) ? $params['location_id'] : '';
      if (strlen($locationId) == 0) {
        return ConditionHelpers::condition404('Location ' . ConstantaHelpers::DATA_EMPTY);
      }

      $delete = LocationModel::query()->find($locationId);

      if (is_null($delete)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }

      if (!is_null($delete->dihapus_pada)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }

      $delete->dihapus_pada = FormatHelpers::IndonesiaFormatData();
      $delete->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, []);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
