<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\LokasiModel;

class LokasiRepo {

  public function getList(){
    try {
      $s = request()->s;
      $lokasi = LokasiModel::query()->data()
      ->when($s, function($data) use($s){
      $data = $data->where('lokasi','ILIKE', '%'. $s . '%')
      ->orWhere('slug' , 'ILIKE', '%'. $s.'%');
      })
      ->get()->makeHidden(['diubah_pada' , 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $lokasi);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getShowData($slug){
    try {
      $data = LokasiModel::query()->where('slug', $slug)->first();
      if(is_null($data)){
      return ResponseHelpers::Success(404, ConstantaHelpers::DATA_NOT_FOUND, []);
      }
      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getSave($params){
    
    try {
      $lokasi = isset($params['lokasi']) ? $params['lokasi'] : '';      
      if(strlen($lokasi) == 0){
        return ConditionHelpers::condition404('Lokasi '. ConstantaHelpers::DATA_EMPTY);
      }
  
      $lokasiId = isset($params['lokasi_id']) ? $params['lokasi_id'] : '';
      if(strlen($lokasiId) == 0){
        $data = new LokasiModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      }else{
        $data = LokasiModel::query()->find($lokasiId);
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();

        if(is_null($data)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if(!is_null($data->dihapus_pada)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }

      $data->lokasi = Str::ucfirst($lokasi);
      $data->slug = Str::slug($lokasi);
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
    
  }
  public function getDeleted($params){

    try {
      $lokasiId = isset($params['lokasi_id'])? $params['lokasi_id'] : '';
      if(strlen($lokasiId) == 0){
        return ConditionHelpers::condition404('Lokasi '. ConstantaHelpers::DATA_EMPTY);
      }

      $data= LokasiModel::query()->find($lokasiId);

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
