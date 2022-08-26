<?php

namespace App\Repo\Member;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\PostinganMagangModel;

class UploadPostinganMagangRepo{

  public function getList(){
    try {
      $data = PostinganMagangModel::query()->data()
      ->where('member_id', auth()->guard('members')->user()->member_id)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
      return ResponseHelpers::Success(200,ConstantaHelpers::GET_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  
  public function getSave($params){
    try {

      $judul = isset($params['judul']) ? $params['judul'] : '';
      if(strlen($judul) == 0){
        return ResponseHelpers::Failed(404, 'Judul '. ConstantaHelpers::DATA_EMPTY);
      }
      $deskripsi = isset($params['deskripsi']) ? $params['deskripsi'] : '';
      if(strlen($deskripsi) == 0){
        return ResponseHelpers::Failed(404, 'Deskripsi '. ConstantaHelpers::DATA_EMPTY);
      }
      $status = isset($params['status']) ? $params['status'] : '';
      if(strlen($status) == 0){
        return ResponseHelpers::Failed(404, 'Status '. ConstantaHelpers::DATA_EMPTY);
      }
      $lokasId = isset($params['lokasi_id']) ? $params['lokasi_id'] : '';
      if(strlen($lokasId) == 0){
        return ResponseHelpers::Failed(404, 'Lokasi '. ConstantaHelpers::DATA_EMPTY);
      }
      $kategoriMagangId = isset($params['kategori_magang_id']) ? $params['kategori_magang_id'] : '';
      if(strlen($kategoriMagangId) == 0){
        return ResponseHelpers::Failed(404, 'Kategori '. ConstantaHelpers::DATA_EMPTY);
      }
      $favoriteMagangId = isset($params['favorite_magang_id']) ? $params['favorite_magang_id'] : '';
      if(strlen($favoriteMagangId) == 0){
        return ResponseHelpers::Failed(404, 'Favorite '. ConstantaHelpers::DATA_EMPTY);
      }
      $tglBuka = isset($params['tgl_buka']) ? $params['tgl_buka'] : '';
      if(strlen($tglBuka) == 0){
        return ResponseHelpers::Failed(404, 'Tanggal Buka '. ConstantaHelpers::DATA_EMPTY);
      }
      $tglTutup = isset($params['tgl_tutup']) ? $params['tgl_tutup'] : '';
      if(strlen($tglTutup) == 0){
        return ResponseHelpers::Failed(404, 'Tanggal Tutup '. ConstantaHelpers::DATA_EMPTY);
      }

      $gambar = null;

      $postinganMagangId = isset($params['postingan_magang_id'])? $params['postingan_magang_id'] : '';
      if(strlen($postinganMagangId) == 0){
        $data = new PostinganMagangModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
        $data->member_id = auth()->guard('members')->user()->member_id;
      }else{
        $data = PostinganMagangModel::find($postinganMagangId);
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();

        if(is_null($data)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_EMPTY);
        }

        if(!is_null($data->dihapus_pada)){
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }

      $data->judul = $judul;
      $data->slug = Str::slug($judul);
      $data->deskripsi = $deskripsi;
      $data->lokasi_id = $lokasId;
      $data->kategori_magang_id = $kategoriMagangId;
      $data->favorite_magang_id = $favoriteMagangId;
      $data->tgl_buka = $tglBuka;
      $data->tgl_tutup = $tglTutup;
      $data->status = $status;

      
      if (request()->hasFile('gambar')) {
        $fullname = Str::replace(' ', '-',Str::lower(auth()->guard('members')->user()->fullname));
        $gambar = $fullname. '-'. Carbon::now()->format('Ymdhis'). '.'.'jpg';
        request()->file('gambar')->move('postingan' ,$gambar);

        $current = base_path('postingan') .'/'. $data->gambar;
        if(file_exists($current)){
          unlink($current);
        }
        $data->gambar = $gambar;
      }
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getDeleted($postinganMagangId){
    try {
      $postinganMagangId = isset($params['postingan_magang_id']) ? $params['postingan_magang_id']: '';
      if(strlen($postinganMagangId) == 0){
      return ResponseHelpers::Failed(404, 'Postingan '.ConstantaHelpers::DATA_EMPTY);
      }
      $data = PostinganMagangModel::query()->find($postinganMagangId);
      if(is_null($data)){
      return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_EMPTY);
      }
      if(!is_null($data->dihapus_pada)){
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }
      $data->save();
      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, []);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
