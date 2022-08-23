<?php

namespace App\Helpers;

use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;

class ConditionHelpers{
  public static function conditionIf($variable, $text = null){
    if(strlen($variable) == 0){
      return ResponseHelpers::Failed(404, $text . ConstantaHelpers::DATA_EMPTY);
    }
  }
}
