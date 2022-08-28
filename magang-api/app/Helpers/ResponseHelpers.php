<?php

namespace App\Helpers;

class ResponseHelpers
{
  public static function Success($code, $message, $data)
  {
    //i  will return json multiple data data
    return response()->json([
      'code' => $code,
      //and code here random implementation code maybe 200, 201, 401 and other
      'message' => $message,
      //and message and text field get data success, example : " Successfully get data"
      'data' => $data,
      // data in here object return response maybe array or object, but in return here execution array.
    ]);
  }
  public static function Failed($code, $message)
  {
    //i  will return json failed with th try catch
    return response()->json([
      'code' => $code,
      //and code here random implementation code maybe, 401 and 404
      'message' => $message,
      //and message and text field notification failed , example : "Ups! Sorry maybe code wrong, cek please your code"
    ]);
  }

  public static function Validation($message)
  {
    return $message . ' ' . ConstantaHelpers::DATA_EMPTY;
  }
}
