<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\TechnologyModel;
use Illuminate\Support\Facades\Validator;

class TechnologyRepo
{

  public function getAllTechnology()
  {
    try {
      $kategori = TechnologyModel::query()->data()
        ->when(request()->search, function ($data) {
          $data->where('technology', 'ILIKE', '%' . request()->search . '%')
            ->orWhere('slug', 'ILIKE', '%' . request()->search . '%');
        })
        ->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $kategori);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getSaveTechnology($params)
  {
    try {
      $validator = Validator::make($params->all(), [
        'technology' => 'required|max:255',
      ], [
        'technology.required' => 'Teknologi ' . ConstantaHelpers::DATA_EMPTY
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $technologyId = isset($params['technology_id']) ? $params['technology_id'] : '';
      if (strlen($technologyId) == 0) {
        // create new
        $data = new TechnologyModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      } else {
        $data = TechnologyModel::query()->find($technologyId);
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if (is_null($data)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if (!is_null($data->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $data->technology = Str::upper($params->technology);
      $data->slug = Str::slug($params->technology);
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getDeleted($params)
  {
    try {
      $technologyId = isset($params['technology_id']) ? $params['technology_id'] : '';
      if (strlen($technologyId) == 0) {
        return ConditionHelpers::condition404('Technology Id ' . ConstantaHelpers::DATA_EMPTY);
      }
      $data = TechnologyModel::query()->find($technologyId);
      if (is_null($data)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }
      if (!is_null($data->dihapus_pada)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }
      $data->dihapus_pada = FormatHelpers::IndonesiaFormatData();
      $data->save();
      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
