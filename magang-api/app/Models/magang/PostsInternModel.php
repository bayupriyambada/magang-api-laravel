<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class PostsInternModel extends Model
{
	protected $table = "posts_intern";
	protected $primaryKey = "posts_intern_id";
	public $timestamps = false;
	// public $appends = ["img_url"];

	public function scopeData($query)
	{
		return $query
			->whereNull("dihapus_pada")
			->where("status", 1)
			->with(["member", "location", "categories", "technology"])
			->selectRaw(
				"*,ROW_NUMBER() over(ORDER BY posts_intern_id desc) no_urut"
			);
	}
	public function scopeSlug($query, $slug)
	{
		return $query
			->where("slug", $slug)
			->with(["member", "location", "categories"]);
	}

	// public function getImgUrlAttribute()
	// {
	// 	return [
	// 		"url" => url("postingan") . "/" . $this->gambar,
	// 	];
	// }

	public function scopeSearch($value)
	{
		return $value
			->whereRaw("LOWER(title) like ?", [
				"%" . strtolower(request()->search) . "%",
			])
			->whereRaw("LOWER(slug) like ?", [
				"%" . strtolower(request()->search) . "%",
			])
			->whereRelation("location", function ($location) {
				$location
					->whereRaw("LOWER(location) like ?", [
						"%" . strtolower(request()->location) . "%",
					])
					->orWhereRaw("LOWER(slug) like ?", [
						"%" . strtolower(request()->location) . "%",
					]);
			})
			->whereRelation("categories", function ($categories) {
				$categories
					->whereRaw("LOWER(categories) like ?", [
						"%" . strtolower(request()->categories) . "%",
					])
					->orWhereRaw("LOWER(slug) like ?", [
						"%" . strtolower(request()->categories) . "%",
					]);
			})
			->whereRelation("technology", function ($technology) {
				$technology
					->whereRaw("LOWER(technology) like ?", [
						"%" . strtolower(request()->technology) . "%",
					])
					->orWhereRaw("LOWER(slug) like ?", [
						"%" . strtolower(request()->technology) . "%",
					]);
			});
	}

	public function member()
	{
		return $this->belongsTo("App\Models\Member", "member_id")->select(
			"member_id",
			"fullname",
			"email"
		);
	}
	public function location()
	{
		return $this->belongsTo(
			"App\Models\magang\LocationModel",
			"location_id"
		)->select("location_id", "location", "slug");
	}
	public function categories()
	{
		return $this->belongsTo(
			"App\Models\magang\CategoriesInternModel",
			"categories_intern_id"
		)->select("categories_intern_id", "categories", "slug");
	}
	public function technology()
	{
		return $this->belongsTo(
			"App\Models\magang\TechnologyModel",
			"technology_id"
		)->select("technology_id", "technology", "slug");
	}
}
