<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\FavoritModel;

class FavoritRepo {
  public function getList(){
   try {
    $s = request()->s;
    $data = FavoritModel::query()->data()
    ->when($s, function($data) use($s){
      $data = $data->where('favorit','ILIKE', '%'. $s . '%')
        ->orWhere('slug' , 'ILIKE', '%'. $s.'%');
    })
    ->get()->makeHidden(['diubah_pada' , 'dihapus_pada']);
    return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
   } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getShowData($slug){
    try {
      $data = FavoritModel::query()->where('slug', $slug)
      ->first();
      if(is_null($data)){
        return ResponseHelpers::Success(404, ConstantaHelpers::DATA_NOT_FOUND, []);
      }
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  
  public function getSave($params){
    try {
      $favorit = isset($params['favorit']) ? $params['favorit'] :'';
      if(strlen($favorit) == 0){
        return ConditionHelpers::condition404('Favorit ' . ConstantaHelpers::DATA_EMPTY);
      }
      $id = isset($params['favorite_magang_id']) ? $params['favorite_magang_id'] : '';
      if(strlen($id) == 0){
        $data = new FavoritModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      }else{
        $data = FavoritModel::query()->find($id);
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if(is_null($data)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if(!is_null($data->dihapus_pada)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $data->favorit = Str::ucfirst($favorit);
      $data->slug = Str::slug($favorit);
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  
  public function getDeleted($id){
    try {
      $data = FavoritModel::query()->find($id);
      if(is_null($data)){
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }
      if(!is_null($data->dihapus_pada)){
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }
      $data->dihapus_pada = FormatHelpers::IndonesiaFormatData();
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, []);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
