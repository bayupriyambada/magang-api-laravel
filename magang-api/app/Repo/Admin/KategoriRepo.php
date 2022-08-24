<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\KategoriModel;

class KategoriRepo {
    
  public function getList(){
    try {
      $s = request()->s;
      $kategori = KategoriModel::query()->data()
      ->when($s, function($data) use($s){
        $data = $data->where('kategori','ILIKE', '%'.$s . '%')
          ->orWhere('slug' , 'ILIKE', '%'. $s .'%');
      })
      ->get()->makeHidden(['diubah_pada' , 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $kategori);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getShowData($slug){
    try {
      $data = KategoriModel::query()->where('slug', $slug)
      ->first();
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
      $kategori = isset($params['kategori']) ? $params['kategori'] : '';
      if(strlen($kategori) == 0){
        return ConditionHelpers::condition404('Kategori '. ConstantaHelpers::DATA_EMPTY);
      }

      $kategoriId = isset($params['kategori_magang_id']) ? $params['kategori_magang_id'] : '';
      if(strlen($kategoriId) == 0){
        // create new
        $data = new KategoriModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      }else{
        $data= KategoriModel::query()->find($kategoriId);
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if(is_null($data)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if(!is_null($data->dihapus_pada)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $data->kategori = Str::ucfirst($kategori);
      $data->slug = Str::slug($kategori);
      $data->save();
      
      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getDeleted($params){
    try {
      /* It's a variable that is not used. */
      $kategorId = isset($params['kategori_magang_id']) ? $params['kategori_magang_id'] : '';
      if(strlen($kategorId) == 0){
        return ConditionHelpers::condition404('Uuid '. ConstantaHelpers::DATA_EMPTY); 
      }

      $data = KategoriModel::query()->find($kategorId);
      if(is_null($data)){
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }
      if(!is_null($data->dihapus_pada)){
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
