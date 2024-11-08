<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\NewPass_Request;
use App\Http\Requests\Auth\Pass_Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Trait\ApiResponseTrait;
use App\Services\Auth_Service;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected Auth_Service $auth_UserService)
    {

    }

    public function register(RegisterRequest $request){
        $input_data=$request->validated();
        $result=$this->auth_UserService->register($input_data);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            // response data preparation:
            $output['auth_token']   = $result_data['auth_token'];
            $output['User']=$result_data['User'];


    }
    return $this->send_response($output, $result['msg'], $result['status_code']);

}


public function login(LoginRequest $request)
{

 $input_data=$request->validated();
 $result=$this->auth_UserService->login($input_data);
 $output = [];
 if ($result['status_code'] == 200) {
     $result_data = $result['data'];
     // response data preparation:
     $output['auth_token']   = $result_data['auth_token'];
     $output['user']= $result_data['user'];
    }

 return $this->send_response($output, $result['msg'], $result['status_code']);


}


public function logout()
{
    $result = $this->auth_UserService->logout();

    return $this->send_response($result, $result['msg'], $result['status_code']);

}

public function get_profile(){
    $result= $this->auth_UserService->get_profile();

    return $this->send_response($result, $result['msg'], $result['status_code']);

}

public function rest_pass(Pass_Request $request){
    $input_data=$request->validated();
    $result= $this->auth_UserService->rest_pass($input_data);
    $output=[];
    if ($result['status_code'] == 200) {
        $result_data = $result['data'];

    }

    return $this->send_response($result['data'], $result['msg'], $result['status_code']);


}




public function new_pass(NewPass_Request $request){
    $input_data=$request->validated();
    $result= $this->auth_UserService->changePassword($input_data);


    return $this->send_response($result, $result['msg'], $result['status_code']);


}

public function edit_profile(ProfileRequest $request){
    $input_data=$request->validated();
    $result= $this->auth_UserService->edit_profile($input_data);


    return $this->send_response($result, $result['msg'], $result['status_code']);



}

}


