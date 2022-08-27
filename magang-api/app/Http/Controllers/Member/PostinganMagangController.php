<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Repo\Member\PostinganMagangRepo;
use Illuminate\Http\Request;

class PostinganMagangController extends Controller
{
  protected $query;

  public function __construct(PostinganMagangRepo $repo)
  {
    $this->query = $repo;
  }
  public function getList()
  {
    return $this->query->getAllPostsIntern();
  }
  public function getSave(Request $request)
  {
    return $this->query->getSavePostsIntern($request);
  }
  public function getSlug($slug)
  {
    return $this->query->getSlugPostsIntern($slug);
  }
  public function getDeleted($postsInternId)
  {
    return $this->query->getDeletePostsIntern($postsInternId);
  }
}
