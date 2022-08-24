<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model {
  protected $table = 'kategori_magang';
  protected $primaryKey = 'kategori_magang_id';
  public $timestamps = false;

  // condition accessor camelCase in here when you used and repo data query
  public function scopeData($query){
  return $query
  ->whereNull('dihapus_pada')
  ->where('status' , 1)
  ->selectRaw(
  '*, ROW_NUMBER() over(ORDER BY kategori_magang_id DESC) no_urut');
  }
}
