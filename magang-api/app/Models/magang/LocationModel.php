<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{

  protected $table = 'location';
  protected $primaryKey = 'location_id';
  public $timestamps = false;
  public function scopeData($query)
  {
    return $query->whereNull('dihapus_pada')
      ->selectRaw('*,ROW_NUMBER() over(ORDER BY location_id desc) no_urut');
  }
}
