<?php

namespace App\Models\Magang;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class PostinganMagangModel extends Model{
  protected $table = 'postingan_magang';
  protected $primaryKey = 'postingan_magang_id';
  public $timestamps = false;

  public function scopeData($query){
    return $query->whereNull('dihapus_pada')
    ->where('status', 1)
    ->with(['member','lokasi','kategori', 'teknologi'])
    ->selectRaw('*,ROW_NUMBER() over(ORDER BY postingan_magang_id desc) no_urut');
  }
  public function scopeSlug($query,$slug){
    return $query->where('slug' ,$slug)
    ->with(['member','lokasi','kategori']);
  }

  public $appends = ['img_url'];

  public function getImgUrlAttribute(){
    return [
      'url' => url('postingan') .'/'. $this->gambar,
    ];
  }

  public function scopeSearch($value){
    return $value->when(request()->s , function($s){
    $s->where('judul', 'ilike', '%'. request()->s . '%')
    ->orWhere('slug', 'ilike', '%'. request()->s . '%');
    })
    ->whereRelation('lokasi', function($l){
    $l->where('lokasi', 'ilike', '%'. request()->l . '%')
    ->orWhere('slug', 'ilike', '%'. request()->l . '%');
    })
    ->whereRelation('kategori', function($k){
    $k->where('kategori', 'ilike', '%'. request()->k . '%')
    ->orWhere('slug', 'ilike', '%'. request()->k . '%');
    })
    ->whereRelation('teknologi', function($t){
    $t->where('teknologi', 'ilike', '%'. request()->t. '%')
    ->orWhere('slug', 'ilike', '%'. request()->t . '%');
    });
  }
  

  public function member(){
    return $this->belongsTo('App\Models\Member' , 'member_id')->select('member_id','fullname','email');
  }
  public function lokasi(){
    return $this->belongsTo('App\Models\magang\LokasiModel' , 'lokasi_id')->select('lokasi_id','lokasi','slug');
  }
  public function kategori(){
    return $this->belongsTo('App\Models\magang\KategoriModel' , 'kategori_magang_id')->select('kategori_magang_id','kategori', 'slug');
  }
  public function teknologi(){
    return $this->belongsTo('App\Models\magang\TeknologiModel' , 'teknologi_magang_id')->select('teknologi_magang_id','teknologi', 'slug');
  }
}
