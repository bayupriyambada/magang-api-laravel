<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;


class FavoritModel extends Model {

  protected $table = 'favorit_magang';
  protected $primaryKey = 'uuid';
  public $timestamps = false;
  public $incrementing = false;
  protected $keyType = 'string';

  protected $casts = [
    'uuid' => 'string'
  ];

  public function scopeData($query){
    return $query->whereNull('dihapus_pada')
      ->selectRaw('*, ROW_NUMBER() over(ORDER BY dibuat_pada desc) no_urut');
  }
}
