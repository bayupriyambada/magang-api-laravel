<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class PostinganMagangModel extends Model
{
	protected $table = "postingan_magang";
	protected $primaryKey = "postingan_magang_id";
	public $timestamps = false;
	public $appends = ["img_url"];

	public function scopeData($query)
	{
		return $query
			->whereNull("dihapus_pada")
			->where("status", 1)
			->with(["member", "lokasi", "kategori", "teknologi"])
			->selectRaw(
				"*,ROW_NUMBER() over(ORDER BY postingan_magang_id desc) no_urut"
			);
	}
	public function scopeSlug($query, $slug)
	{
		return $query
			->where("slug", $slug)
			->with(["member", "lokasi", "kategori"]);
	}

	public function getImgUrlAttribute()
	{
		return [
			"url" => url("postingan") . "/" . $this->gambar,
		];
	}

	public function scopeSearch($value)
	{
		return $value
			->whereRaw("LOWER(judul) like ?", [
				"%" . strtolower(request()->search) . "%",
			])
			->whereRaw("LOWER(slug) like ?", [
				"%" . strtolower(request()->search) . "%",
			])
			->whereRelation("lokasi", function ($lokasi) {
				$lokasi
					->whereRaw("LOWER(lokasi) like ?", [
						"%" . strtolower(request()->lokasi) . "%",
					])
					->orWhereRaw("LOWER(slug) like ?", [
						"%" . strtolower(request()->lokasi) . "%",
					]);
			})
			->whereRelation("kategori", function ($kategori) {
				$kategori
					->whereRaw("LOWER(kategori) like ?", [
						"%" . strtolower(request()->kategori) . "%",
					])
					->orWhereRaw("LOWER(slug) like ?", [
						"%" . strtolower(request()->kategori) . "%",
					]);
			})
			->whereRelation("teknologi", function ($teknologi) {
				$teknologi
					->whereRaw("LOWER(teknologi) like ?", [
						"%" . strtolower(request()->teknologi) . "%",
					])
					->orWhereRaw("LOWER(slug) like ?", [
						"%" . strtolower(request()->teknologi) . "%",
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
	public function lokasi()
	{
		return $this->belongsTo(
			"App\Models\magang\LokasiModel",
			"lokasi_id"
		)->select("lokasi_id", "lokasi", "slug");
	}
	public function kategori()
	{
		return $this->belongsTo(
			"App\Models\magang\KategoriModel",
			"kategori_magang_id"
		)->select("kategori_magang_id", "kategori", "slug");
	}
	public function teknologi()
	{
		return $this->belongsTo(
			"App\Models\magang\TeknologiModel",
			"teknologi_magang_id"
		)->select("teknologi_magang_id", "teknologi", "slug");
	}
}
