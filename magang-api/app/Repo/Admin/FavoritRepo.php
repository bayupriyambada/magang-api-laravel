<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\FavoritModel;

class FavoritRepo
{
  public function getAllFavorite()
  {
    try {
      $allFavorite = FavoritModel::query()->data()
        ->when(request()->favorite, function ($searchFavorite) {
          $searchFavorite
            ->whereRaw("LOWER(favorit) like ?", [
              "%" . strtolower(request()->favorite) . "%",
            ])
            ->whereRaw("LOWER(slug) like ?", [
              "%" . strtolower(request()->favorite) . "%",
            ]);
        })
        ->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $allFavorite);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getSlugFavorite($slug)
  {
    try {
      $slugFavorite = FavoritModel::query()->where('slug', $slug)
        ->first();
      if (is_null($slugFavorite)) {
        return ResponseHelpers::Success(404, ConstantaHelpers::DATA_NOT_FOUND, []);
      }
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $slugFavorite);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getSaveFavorite($params)
  {
    try {
      $favorite = isset($params['favorit']) ? $params['favorit'] : '';
      if (strlen($favorite) == 0) {
        return ConditionHelpers::condition404('Favorit ' . ConstantaHelpers::DATA_EMPTY);
      }
      $favoriteId = isset($params['favorite_magang_id']) ? $params['favorite_magang_id'] : '';
      if (strlen($favoriteId) == 0) {
        $saved = new FavoritModel();
        $saved->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      } else {
        $saved = FavoritModel::query()->find($favoriteId);
        $saved->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if (is_null($saved)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if (!is_null($saved->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $saved->favorit = Str::ucfirst($favorite);
      $saved->slug = Str::slug($favorite);
      $saved->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $saved);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getDeleteFavorite($favoriteId)
  {
    try {
      $deleteFavorite = FavoritModel::query()->find($favoriteId);
      if (is_null($deleteFavorite)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }
      if (!is_null($deleteFavorite->dihapus_pada)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }
      $deleteFavorite->dihapus_pada = FormatHelpers::IndonesiaFormatData();
      $deleteFavorite->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, []);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
