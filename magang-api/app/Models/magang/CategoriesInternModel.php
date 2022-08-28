<?php

namespace App\Models\Magang;

use Illuminate\Database\Eloquent\Model;

class CategoriesInternModel extends Model
{
  protected $table = 'categories_intern';
  protected $primaryKey = 'categories_intern_id';
  public $timestamps = false;

  // condition accessor camelCase in here when you used and repo data query
  public function scopeData($query)
  {
    return $query
      ->whereNull('dihapus_pada')
      ->selectRaw(
        '*, ROW_NUMBER() over(ORDER BY categories_intern_id DESC) no_urut'
      );
  }
}
