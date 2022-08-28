<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use Illuminate\Support\Facades\Validator;
use App\Models\Magang\CategoriesInternModel;

class CategoriesInternRepo
{

  public function getAllCategory()
  {
    try {
      $allCategory = CategoriesInternModel::query()->data()
        ->when(request()->search, function ($search) {
          $search->where('categories', 'ILIKE', '%' . request()->search . '%')
            ->orWhere('slug', 'ILIKE', '%' . request()->search . '%');
        })
        ->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $allCategory);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getCategorySlug($slug)
  {
    try {
      $categorySlug = CategoriesInternModel::query()->where('slug', $slug)
        ->first();
      if (is_null($categorySlug)) {
        return ResponseHelpers::Success(404, ConstantaHelpers::DATA_NOT_FOUND, []);
      }
      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $categorySlug);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getCategorySave($params)
  {
    try {
      $validator = Validator::make($params->all(), [
        'categories' => 'required|max:255',
      ], [
        'categories.required' => ResponseHelpers::Validation('Categories')
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $categoryId = isset($params['categories_intern_id']) ? $params['categories_intern_id'] : '';
      if (strlen($categoryId) == 0) {
        // create new
        $savedCategory = new CategoriesInternModel();
        $savedCategory->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      } else {
        $savedCategory = CategoriesInternModel::query()->find($categoryId);
        $savedCategory->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if (is_null($savedCategory)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if (!is_null($savedCategory->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $savedCategory->categories = Str::ucfirst($params->categories);
      $savedCategory->slug = Str::slug($params->categories);
      $savedCategory->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $savedCategory);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getCategoryDelete($params)
  {
    try {
      $categoryId = isset($params['categories_intern_id']) ? $params['categories_intern_id'] : '';
      if (strlen($categoryId) == 0) {
        return ConditionHelpers::condition404('Categories ' . ConstantaHelpers::DATA_EMPTY);
      }

      $deleteCategory = CategoriesInternModel::query()->find($categoryId);
      if (is_null($deleteCategory)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }
      if (!is_null($deleteCategory->dihapus_pada)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }
      $deleteCategory->dihapus_pada = FormatHelpers::IndonesiaFormatData();
      $deleteCategory->save();
      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, $deleteCategory);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getCategoryTrash()
  {
    try {
      $trashCategories = CategoriesInternModel::query()->whereNotNull('dihapus_pada')->get();
      // dd($trashCategories);

      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $trashCategories);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getCategoryDeletePermanent()
  {
    try {
      $trashCategories = CategoriesInternModel::query()->whereNotNull('dihapus_pada')->first();
      dd($trashCategories);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
