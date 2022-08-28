<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use Illuminate\Support\Facades\Validator;
use App\Models\Magang\QualificationModel;

class QualificationRepo
{

  public function getAllQualification()
  {
    try {
      $allQualification = QualificationModel::query()->data()
        ->when(request()->search, function ($search) {
          $search->where('qualification', 'ILIKE', '%' . request()->search . '%');
        })
        ->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $allQualification);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getSaveQualification($params)
  {
    try {
      $validator = Validator::make($params->all(), [
        'qualification' => 'required|max:255',
      ], [
        'qualification.required' => ResponseHelpers::Validation('Qualification Degree')
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $qualificationId = isset($params['qualification_id']) ? $params['qualification_id'] : '';
      if (strlen($qualificationId) == 0) {
        // create new
        $save = new QualificationModel();
        $save->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      } else {
        $save = QualificationModel::query()->find($qualificationId);
        $save->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if (is_null($save)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if (!is_null($save->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $save->qualification = Str::upper($params->qualification);
      $save->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $save);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getDeleteQualification($params)
  {
    try {
      $qualificationId = isset($params['qualification_id']) ? $params['qualification_id'] : '';
      if (strlen($qualificationId) == 0) {
        return ConditionHelpers::condition404('Qualification ' . ConstantaHelpers::DATA_EMPTY);
      }

      $delete = QualificationModel::query()->find($qualificationId);
      if (is_null($delete)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }
      if (!is_null($delete->dihapus_pada)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }
      $delete->dihapus_pada = FormatHelpers::IndonesiaFormatData();
      $delete->save();
      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, $delete);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getQualificationTrash()
  {
    try {
      $trashCategories = QualificationModel::query()->whereNotNull('dihapus_pada')->get();
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $trashCategories);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getQualificationDeletePermanent()
  {
    try {
      $trashCategories = QualificationModel::query()->whereNotNull('dihapus_pada')->first();
      dd($trashCategories);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
