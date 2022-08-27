<?php

namespace App\Repo\Member;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;
use Illuminate\Support\Facades\Validator;
use App\Models\Magang\PostinganMagangModel;

class PostinganMagangRepo
{

  public function getAllPostsIntern()
  {
    try {
      $data = PostinganMagangModel::query()->data()
        ->where('member_id', auth()->guard('members')->user()->member_id)->get()->makeHidden(['diubah_pada', 'dihapus_pada']);
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getSavePostsIntern($params)
  {
    try {
      $validator = Validator::make($params->all(), [
        'judul' => 'required|max:255',
        'deskripsi' => 'required',
        'status' => 'required',
        'lokasi_id' => 'required',
        'kategori_magang_id' => 'required',
        'teknologi_magang_id' => 'required',
        'teknologi' => 'required',
        'tgl_buka' => 'required',
      ], [
        'judul.required' => 'Judul ' . ConstantaHelpers::DATA_EMPTY,
        'deskripsi.required' => 'Deskripsi ' . ConstantaHelpers::DATA_EMPTY,
        'status.required' => 'Status ' . ConstantaHelpers::DATA_EMPTY,
        'lokasi_id.required' => 'Lokasi ' . ConstantaHelpers::DATA_EMPTY,
        'kategori_magang_id.required' => 'Kategori ' . ConstantaHelpers::DATA_EMPTY,
        'teknologi_magang_id.required' => 'Teknologi ' . ConstantaHelpers::DATA_EMPTY,
        'teknologi_magang_id.required' => 'Teknologi ' . ConstantaHelpers::DATA_EMPTY,
        'tgl_buka.required' => 'Tanggal Buka ' . ConstantaHelpers::DATA_EMPTY,
      ]);
      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }
      $gambar = null;
      $postinganMagangId = isset($params['postingan_magang_id']) ? $params['postingan_magang_id'] : '';
      if (strlen($postinganMagangId) == 0) {
        $data = new PostinganMagangModel();
        $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
        $data->member_id = auth()->guard('members')->user()->member_id;
      } else {
        $data = PostinganMagangModel::find($postinganMagangId);
        $data->diubah_pada = FormatHelpers::IndonesiaFormatData();

        if (is_null($data)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_EMPTY);
        }

        if (!is_null($data->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $data->judul = $params->judul;
      $data->slug = Str::slug($params->judul);
      $data->deskripsi = $params->deskripsi;
      $data->lokasi_id = $params->lokasi_id;
      $data->kategori_magang_id = $params->kategori_magang_id;
      $data->teknologi_magang_id = $params->teknologi_magang_id;
      $data->tgl_buka = $params->tgl_buka;
      $data->status = (int)$params->status;

      if (request()->hasFile('gambar')) {
        $fullname = Str::replace(' ', '-', Str::lower(auth()->guard('members')->user()->fullname));
        $gambar = $fullname . '-' . Carbon::now()->format('Ymdhis') . '.' . 'jpg';
        request()->file('gambar')->move('postingan', $gambar);

        $current = base_path('postingan') . '/' . $data->gambar;
        if (file_exists($current)) {
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

  public function getSlugPostsIntern($slug)
  {
    try {
      $slugPostsIntern = PostinganMagangModel::query()->where('slug', $slug)
        ->where('member_id', auth()->guard('members')->user()->member_id)
        ->first();
      if (is_null($slugPostsIntern)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_NOT_FOUND);
      }
      return ResponseHelpers::Success(200, ConstantaHelpers::GET_DATA, $slugPostsIntern);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
  public function getDeletePostsIntern($postinganMagangId)
  {
    try {
      $postinganMagangId = isset($params['postingan_magang_id']) ? $params['postingan_magang_id'] : '';
      if (strlen($postinganMagangId) == 0) {
        return ResponseHelpers::Failed(404, 'Postingan ' . ConstantaHelpers::DATA_EMPTY);
      }
      $delete = PostinganMagangModel::query()->find($postinganMagangId);
      if (is_null($delete)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_EMPTY);
      }
      if (!is_null($delete->dihapus_pada)) {
        return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
      }
      $delete->save();
      return ResponseHelpers::Success(200, ConstantaHelpers::DELETED_DATA, []);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }
}
