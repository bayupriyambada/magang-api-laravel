<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class PostinganMagangModel extends Model{
  protected $table = 'postingan_magang';
  protected $primaryKey = 'postingan_magang_id';
  public $timestamp = false;


   public function scopeData($query){
    return $query->whereNull('dihapus_pada')
    ->where('status', 1)
    ->selectRaw('*,ROW_NUMBER() over(ORDER BY postingan_magang_id desc) no_urut');
   }
}
