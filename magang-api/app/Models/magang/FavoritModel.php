<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;


class FavoritModel extends Model {

  protected $table = 'favorite_magang';
  protected $primaryKey = 'favorite_magang_id';
  public $timestamps = false;
  // public $incrementing = false;
  // protected $keyType = 'string';

  // protected $casts = [
  //   'uuid' => 'string'
  // ];

  public function scopeData($query){
    return $query->whereNull('dihapus_pada')
      ->selectRaw('*, ROW_NUMBER() over(ORDER BY favorite_magang_id desc) no_urut');
  }
}
