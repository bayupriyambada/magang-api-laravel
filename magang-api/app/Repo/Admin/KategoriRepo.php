<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\KategoriModel;

class KategoriRepo
{

  public function getAllCategory()
  {
    try {
      $allCategory = KategoriModel::query()->data()
        ->when(request()->search, function ($search) {
          $search->where('kategori', 'ILIKE', '%' . request()->search . '%')
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
      $categorySlug = KategoriModel::query()->where('slug', $slug)
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
      $category = isset($params['kategori']) ? $params['kategori'] : '';
      if (strlen($category) == 0) {
        return ConditionHelpers::condition404('Kategori ' . ConstantaHelpers::DATA_EMPTY);
      }

      $categoryId = isset($params['kategori_magang_id']) ? $params['kategori_magang_id'] : '';
      if (strlen($categoryId) == 0) {
        // create new
        $savedCategory = new KategoriModel();
        $savedCategory->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      } else {
        $savedCategory = KategoriModel::query()->find($categoryId);
        $savedCategory->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if (is_null($savedCategory)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if (!is_null($savedCategory->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $savedCategory->kategori = Str::ucfirst($category);
      $savedCategory->slug = Str::slug($category);
      $savedCategory->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $savedCategory);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getCategoryDelete($params)
  {
    try {
      $categoryId = isset($params['kategori_magang_id']) ? $params['kategori_magang_id'] : '';
      if (strlen($categoryId) == 0) {
        return ConditionHelpers::condition404('Uuid ' . ConstantaHelpers::DATA_EMPTY);
      }

      $deleteCategory = KategoriModel::query()->find($categoryId);
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
}
