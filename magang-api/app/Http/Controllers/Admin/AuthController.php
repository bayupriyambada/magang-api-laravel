<?php

namespace App\Http\Controllers\Admin;

use App\Repo\Admin\AuthRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller{

  protected $query;

  public function __construct(AuthRepo $repo)
  {
    $this->query = $repo;
  }

  public function getLogin(Request $request){
    $data = [
      'email'=> $request->input('email'),
      'password'=> $request->input('password'),
    ];

    $data = $this->query->getLogin($request);
    return $data;
  }
  public function getRegister(Request $request){
    $data = [
      'fullname'=> $request->input('fullname'),
      'email'=> $request->input('email'),
      'password'=> $request->input('password'),
      'jenis_kelamin'=> $request->input('jenis_kelamin'),
      'alamat'=> $request->input('alamat'),
    ];
    $data = $this->query->getRegister($request);
    return $data;
  }

  public function getMe(){
    $data = $this->query->getMe();
    return $data;
  }
}
