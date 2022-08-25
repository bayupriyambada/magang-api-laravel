<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class LokasiModel extends Model{

  protected $table = 'lokasi';
  protected $primaryKey = 'lokasi_id';
  public $timestamps = false;
  // public $incrementing = false;
  // protected $keyType = 'string';

  // protected $casts = [
  // 'uuid' => 'string'
  // ];
  public function scopeData($query){
    return $query->whereNull('dihapus_pada')
      ->selectRaw('*,ROW_NUMBER() over(ORDER BY lokasi_id desc) no_urut');
  }
}
