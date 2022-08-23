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
     $data = FavoritModel::query()->data()->get();
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

      $uuid = isset($params['uuid']) ? $params['uuid'] : '';
      if(strlen($uuid) == 0){
        $data = new FavoritModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      }else{
        $data = FavoritModel::query()->where('uuid', $uuid)->first();
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if(is_null($data)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if(!is_null($data->dihapus_pada)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $data->uuid = Str::uuid();
      $data->favorit = Str::ucfirst($favorit);
      $data->slug = Str::slug($favorit);
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  
  public function getDeleted($params){
    try {
      $uuid = isset($params['uuid']) ? $params['uuid'] : '';
      if(strlen($uuid) == 0){
        return ResponseHelpers::Failed(404, 'Uuid '. ConstantaHelpers::DATA_EMPTY);
      }

      $data = FavoritModel::query()->where('uuid' , $uuid)->first();

      if(is_null($data)){
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }

      if(!is_null($data->dihapus_pada)){
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }

      $data->diubah_pada = FormatHelpers::IndonesiaFormatData();
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, []);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
