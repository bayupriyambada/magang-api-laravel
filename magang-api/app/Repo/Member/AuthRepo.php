<?php

namespace App\Repo\Member;

use Illuminate\Support\Str;
use App\Helpers\FormatHelpers;
use App\Helpers\ResponseHelpers;
use App\Helpers\ConstantaHelpers;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class AuthRepo {

  public function getLogin($params){
    
    $email = isset($params['email'])? $params['email'] : '';
    if(strlen($email) == 0){
      return ResponseHelpers::Failed(404, 'Email ' . ConstantaHelpers::DATA_EMPTY);
    }
    $password = isset($params['password'])? $params['password'] : '';
    if(strlen($password) == 0){
      return ResponseHelpers::Failed(404, 'Password ' . ConstantaHelpers::DATA_EMPTY);
    }

    $usersLogin = Member::where('email',$email)->first();
    if(is_null($usersLogin)){
      return ResponseHelpers::Failed(404, 'Email Not Found');
    }

    $credentials =$params->only(['email' ,'password']);
    // dd($credentials);
    if(!($token = auth()->guard('members')->attempt($credentials))){
      return response()->json(['message' => 'Authorized']);
    }

    if (! $token = auth()->guard('members')->attempt($credentials)) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }
    return response()->json([
      'user' => $usersLogin ,
      'token' => $token
    ],200);
  }

  public function getRegister($params){

  
    try {
      $fullName = isset($params['fullname'])? $params['fullname'] : '';
      if(strlen($fullName) == 0){
        return ResponseHelpers::Failed(404, 'Full Name ' . ConstantaHelpers::DATA_EMPTY);
      }
      $email = isset($params['email'])? $params['email'] : '';
      if(strlen($email) == 0){
        return ResponseHelpers::Failed(404, 'Email ' . ConstantaHelpers::DATA_EMPTY);
      }
      $password = isset($params['password'])? $params['password'] : '';
      if(strlen($password) == 0){
        return ResponseHelpers::Failed(404, 'Password ' . ConstantaHelpers::DATA_EMPTY);
      }
      $jensKelamin = isset($params['jenis_kelamin'])? $params['jenis_kelamin'] : '';
      if(strlen($jensKelamin) == 0){
        return ResponseHelpers::Failed(404, 'Jenis Kelamin ' . ConstantaHelpers::DATA_EMPTY);
      }
      $alamat = isset($params['alamat'])? $params['alamat'] : '';
      if(strlen($alamat) == 0){
        return ResponseHelpers::Failed(404, 'Alamat ' . ConstantaHelpers::DATA_EMPTY);
      }
      $data = new Member();
      $data->fullname = $fullName;
      $data->email = $email;
      $data->password = Hash::make($password);
      $data->jenis_kelamin = $jensKelamin;
      $data->alamat = $alamat;
      $data->dibuat_pada = FormatHelpers::IndonesiaFormatData();
      $data->save();

      return ResponseHelpers::Success(200, ConstantaHelpers::SAVE_DATA, $data);
    } catch (\Throwable $th) {
      return ResponseHelpers::Failed(404, $th->getMessage());
    }  
  }

  public function getMe(){
    return response()->json(auth()->guard('members')->user());
  }

  public function logout()
  {
    auth()->logout();

    return response()->json(['message' => 'Successfully logged out']);
  }

  protected function respondWithToken($token)
  {
    return response()->json([
    'user' => $token,
    'token_type' => 'bearer',
    'expires_in' => auth()->guard('members')->user() * 60 * 24 * 30,
    ]);
  }
}
