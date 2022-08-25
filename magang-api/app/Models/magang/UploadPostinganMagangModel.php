<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class UploadPostinganMagangModel extends Model{
  protected $table = 'upload_postingan_magang';
  protected $primaryKey = 'upload_postingan_magang_id';
  public $timestamps = false;

  public function scopeData($query){
    return $query->whereNull('dihapus_pada')
    ->where('status', 1)
    ->selectRaw('*,ROW_NUMBER() over(ORDER BY upload_postingan_magang_id desc) no_urut');
  }

  public $appends = ['file_url'];

  public function getFileUrlAttribute(){
    return [
      'url' => url('file') .'/'. $this->file_url,
    ];
  }
}
