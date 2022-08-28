<?php

namespace App\Repo\Member;

use Carbon\Carbon;
use App\Jobs\DeletingFiles;
use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Magang\PostsInternModel;
use Illuminate\Support\Facades\Validator;

class PostsInternRepo
{

  // public function deletingFile()
  // {
  //   $deletingFiles = PostsInternModel::query()->select('gambar')->get()->get();
  //   $dir =  base_path() . '\public\postingan';
  //   $deletingFiles1 = scandir($dir);

  //   foreach ($deletingFiles1 as $key => $value) {
  //     if ($key > 1 && !in_array($value, $deletingFiles)) {
  //       $deletingFiles2 = $dir . '\\' . $value;
  //       dispatch(new DeletingFiles($deletingFiles2));
  //     } else {
  //       continue;
  //     }
  //   }
  //   return $deletingFiles;
  // }
  public function getAllPostsIntern()
  {
    try {
      $data = PostsInternModel::query()->data()
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
        'title' => 'required|max:255',
        'description' => 'required',
        'status_active' => 'required',
        'location_id' => 'required',
        'categories_intern_id' => 'required',
        'technology_qualification' => 'required',
        'qualification' => 'required',
        'date_start' => 'required',
        'date_end' => 'required',
      ], [
        'title.required' => 'Title ' . ConstantaHelpers::DATA_EMPTY,
        'description.required' => 'Description ' . ConstantaHelpers::DATA_EMPTY,
        'status_active.required' => 'Status ' . ConstantaHelpers::DATA_EMPTY,
        'location_id.required' => 'Location ' . ConstantaHelpers::DATA_EMPTY,
        'categories_intern_id.required' => 'Categories intern ' . ConstantaHelpers::DATA_EMPTY,
        'technology_qualification.required' => 'Technology qualification ' . ConstantaHelpers::DATA_EMPTY,
        'qualification.required' => 'Qualification ' . ConstantaHelpers::DATA_EMPTY,
        'date_start.required' => 'Date start ' . ConstantaHelpers::DATA_EMPTY,
        'date_end.required' => 'Date end ' . ConstantaHelpers::DATA_EMPTY,
      ]);
      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }
      // $gambar = null;
      $postsInternId = isset($params['posts_intern_id']) ? $params['posts_intern_id'] : '';
      if (strlen($postsInternId) == 0) {
        $save = new PostsInternModel();
        $save->dibuat_pada = FormatHelpers::IndonesiaFormatData();
        $save->member_id = auth()->guard('members')->user()->member_id;
      } else {
        $save = PostsInternModel::find($postsInternId);
        $save->diubah_pada = FormatHelpers::IndonesiaFormatData();

        if (is_null($save)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DATA_EMPTY);
        }

        if (!is_null($save->dihapus_pada)) {
          return ResponseHelpers::Failed(404, ConstantaHelpers::DELETED_DATA_FOUND);
        }
      }
      $save->title = $params->title;
      $save->slug = Str::slug($params->title);
      $save->description = $params->description;
      $save->location_id = $params->location_id;
      $save->qualification = $params->qualification;
      $save->categories_intern_id = $params->categories_intern_id;
      $save->date_start = $params->date_start;
      $save->date_end = $params->date_end;
      $save->status_active = (int)$params->status_active;

      // if (request()->hasFile('gambar')) {
      //   $fullname = Str::replace(' ', '-', Str::lower(auth()->guard('members')->user()->fullname));
      //   $gambar = $fullname . '-' . Carbon::now()->format('Ymdhis') . '.' . 'jpg';
      //   request()->file('gambar')->move('postingan', $gambar);

      //   $current = base_path('postingan') . '/' . $save->gambar;
      //   if (file_exists($current)) {
      //     unlink($current);
      //   }
      //   $save->gambar = $gambar;
      // }
      $save->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $save);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(400, $th->getMessage());
    }
  }

  public function getDetailSlugPostsIntern($slug)
  {
    try {
      $slugPostsIntern = PostsInternModel::query()->where('slug', $slug)
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
  public function getDeletePostsIntern($postsInternId)
  {
    try {
      $postsInternId = isset($params['posts_intern_id']) ? $params['posts_intern_id'] : '';
      if (strlen($postsInternId) == 0) {
        return ResponseHelpers::Failed(404, 'Posts Intern ' . ConstantaHelpers::DATA_EMPTY);
      }
      $delete = PostsInternModel::query()->find($postsInternId);
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
