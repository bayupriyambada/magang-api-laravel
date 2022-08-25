<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class TeknologiModel extends Model{

  protected $table = 'teknologi_magang';
  protected $primaryKey = 'teknologi_magang_id';
  public $timestamps = false;
  public function scopeData($query){
    return $query->whereNull('dihapus_pada')
      ->selectRaw('*,ROW_NUMBER() over(ORDER BY teknologi_magang_id desc) no_urut');
  }

  protected $fillable = ['teknologi' ,'slug' ,'dibuat_pada', 'dihapus_pada', 'diubah_pada'];
}
