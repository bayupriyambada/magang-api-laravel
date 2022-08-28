<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class TechnologyModel extends Model
{

  protected $table = 'technology';
  protected $primaryKey = 'technology_id';
  public $timestamps = false;
  public function scopeData($query)
  {
    return $query->whereNull('dihapus_pada')
      ->selectRaw('*,ROW_NUMBER() over(ORDER BY technology_id desc) no_urut');
  }

  // protected $fillable = ['teknologi', 'slug', 'dibuat_pada', 'dihapus_pada', 'diubah_pada'];
}
