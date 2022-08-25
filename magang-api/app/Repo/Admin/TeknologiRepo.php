<?php

namespace App\Repo\Admin;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConditionHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\KategoriModel;
use App\Models\Magang\TeknologiModel;
use Illuminate\Support\Facades\Validator;

class TeknologiRepo {
    
  public function getList(){
    try {
      $s = request()->s;
      $kategori = TeknologiModel::query()->data()
      ->when($s, function($data) use($s){
        $data = $data->where('teknologi','ILIKE', '%'.$s . '%')
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
      $data = TeknologiModel::query()->where('slug', $slug)
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
      $validator = Validator::make($params->all(), [
        'teknologi' => 'required|max:255',
      ], [
        'teknologi.required' => 'Teknologi ' .ConstantaHelpers::DATA_EMPTY
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $teknologiId = isset($params['teknologi_magang_id']) ? $params['teknologi_magang_id'] : '';
      if(strlen($teknologiId) == 0){
        // create new
        $data = new TeknologiModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      }else{
        $data= TeknologiModel::query()->find($teknologiId);
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();
        if(is_null($data)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
        }
        if(!is_null($data->dihapus_pada)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $data->teknologi = Str::upper($params->teknologi);
      $data->slug = Str::slug($params->teknologi);
      $data->save();
      
      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getDeleted($params){
    try {
      /* It's a variable that is not used. */
      $teknologiId = isset($params['teknologi_magang_id']) ? $params['teknologi_magang_id'] : '';
      if(strlen($teknologiId) == 0){
        return ConditionHelpers::condition404('Uuid '. ConstantaHelpers::DATA_EMPTY); 
      }

      $data = TeknologiModel::query()->find($teknologiId);
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
