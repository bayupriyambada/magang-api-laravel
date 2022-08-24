<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class PostinganMagangModel extends Model{
  protected $table = 'postingan_magang';
  protected $primaryKey = 'postingan_magang_id';
  public $timestamps = false;

  public function scopeData($query){
    return $query->whereNull('dihapus_pada')
    ->where('status', 1)
    ->with(['member','favorit','lokasi','kategori'])
    ->selectRaw('*,ROW_NUMBER() over(ORDER BY postingan_magang_id desc) no_urut');
  }

  public function member(){
    return $this->belongsTo('App\Models\Member' , 'member_id')->select('member_id','fullname','email');
  }
  public function favorit(){
    return $this->belongsTo('App\Models\magang\FavoritModel' , 'favorite_magang_id')->select('favorite_magang_id','favorit','slug');
  }
  public function lokasi(){
    return $this->belongsTo('App\Models\magang\LokasiModel' , 'lokasi_id')->select('lokasi_id','lokasi','slug');
  }
  public function kategori(){
    return $this->belongsTo('App\Models\magang\KategoriModel' , 'kategori_magang_id')->select('kategori_magang_id','kategori', 'slug');
  }
}
