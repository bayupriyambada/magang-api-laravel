<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Repo\Member\PostsInternRepo;
use Illuminate\Http\Request;

class PostsInternController extends Controller
{
  protected $query;

  public function __construct(PostsInternRepo $repo)
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
    return $this->query->getDetailSlugPostsIntern($slug);
  }
  public function getDeleted($postsInternId)
  {
    return $this->query->getDeletePostsIntern($postsInternId);
  }
}
