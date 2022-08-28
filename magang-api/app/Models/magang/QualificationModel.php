<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;


class QualificationModel extends Model
{

  protected $table = 'qualification';
  protected $primaryKey = 'qualification_id';
  public $timestamps = false;

  public function scopeData($query)
  {
    return $query->whereNull('dihapus_pada')
      ->selectRaw('*, ROW_NUMBER() over(ORDER BY qualification_id desc) no_urut');
  }
}
