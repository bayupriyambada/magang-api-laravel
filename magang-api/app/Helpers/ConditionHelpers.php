<?php

namespace App\Helpers;

use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;

class ConditionHelpers{
  public function conditionIf($variable,$text){
    if(strlen($variable) == 0){
      return ResponseHelpers::Failed(404, $text . ConstantaHelpers::DATA_EMPTY);
    }
  }
  
  public static function condition404($text){
    return ResponseHelpers::Failed(404, $text);
  }
  
}
