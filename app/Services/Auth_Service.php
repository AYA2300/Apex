<?php
 namespace App\Services;



use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Trait\FileStorageTrait;

use App\Jobs\ExpireVerificationCode;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

use Spatie\Permission\Models\Role;
use Throwable;

class Auth_Service{
    use HasApiTokens,FileStorageTrait;


    public function Register(array $input_data){
        $data=[];
        $status_code=400;
        $msg='';
        $result=[];



        $user=User::create([

            'name'=>$input_data['name'],
            'email'=>$input_data['email'],
            'password'=>Hash::make($input_data['password']),
            'university_number'=>$input_data['university_number'],
            'confirm_password' => Hash::make($input_data['confirm_password']),


        ]);
        $user->assignRole(Role::where('name','user')->first());
        $auth_token=JWTAuth::fromUser($user);

        $msg = 'registered successfully ';




        $data['User']=$user;
        // $data['qr_imag']=$qr_imag;
        $data['auth_token']=$auth_token;
        $status_code = 200;




        $result =[
            'data' => $data,
            'status_code' => $status_code,
            'msg' => $msg,

        ];
        return $result;




    }

    public function login(array $input_data){

        $data = [];
        $status_code = 400;
        $msg = '';
        $result = [];



        $credentials=[
            'email'=>$input_data['email'],
            'password'=>$input_data['password']
        ];

        if(!$auth_token =Auth::attempt($credentials)){
            $status_code=404;
            $msg ='Please Check your email and password';

        }
        else{
            $user=Auth::user();

            $data=[
                'user'=>$user,
                'auth_token'=>$auth_token
            ];

            $status_code=200;
            $msg="Profile Editd Successfully";}



            $result=[
                'data'=>$data,
                'status_code'=>$status_code,
                'msg'=>$msg
            ];
            return $result;

        }







    public function logout(){


        $status_code = 400;
        $msg = '';
        $result = [];


        Auth::logout();

        $msg='logged out';
        $status_code=200;
        $result=[
            'status_code'=>$status_code,
            'msg'=>$msg




        ];

        return $result;



}

public function get_profile(){

    $status_code = 200;
    $user=Auth::user();
    $data['user']=$user;

    $msg='user profile';

    $result=[
        'data'=>$data,
        'status_code'=>$status_code,
        'msg'=>$msg
    ];
    return $result;




}


public function rest_pass(array $input_data){
    $user =User::where('email',$input_data['email'])->first();

    if(!$user->email==$input_data['email']){
        $status_code=400;
        $msg='email not found';
    }


    $verification_code=Str::random(4);
    $user->verification_code=$verification_code;
    $user->save();
    dd(  $user->verification_code);



   /// ExpireVerificationCode::dispatch($user)->delay(now()->addSeconds(60));
    $this->sendVerificationEmail($input_data['email'], $verification_code);



    $status_code=200;
    $msg=' please check your email for the verification code.';
    $data=$user->email;

    $result=[
        'data'=>$data,
        'status_code'=>$status_code,
        'msg'=>$msg
    ];
    return $result;


}

private function sendVerificationEmail($email, $verification_code)
{
    Mail::raw("Your verification code is: $verification_code", function ($message) use ($email) {
        $message->to($email)
                ->subject('Email Verification');
    });


}



public function changePassword(array $input_data)
{
    // ابحث عن المستخدم باستخدام البريد الإلكتروني
    $user = User::where('email', $input_data['email'])->first();

    // تحقق مما إذا كان المستخدم موجودًا
    if (!$user) {
        return [
            'status_code' => 400,
            'msg' => 'Email not found',
        ];
    }

    // تحقق من صحة رمز التحقق
    if ($user->verification_code !== $input_data['verification_code']) {
        return [
            'status_code' => 400,
            'msg' => 'Invalid verification code',
        ];
    }

    // تحقق من كلمة المرور الجديدة وقم بتحديثها
    if (isset($input_data['new_password'])) {
        $user->password = Hash::make($input_data['new_password']);
    }

    // إلغاء رمز التحقق وحفظ التحديثات
    $user->verification_code = null;
    $user->save();

    return [
        'status_code' => 200,
        'msg' => 'Your password has been changed successfully',
        'data' => ['email' => $user->email],
    ];
}

public function edit_profile(array $input_data)
{
    $user = User::find(auth()->id());

    // Update user's information if data is provided
    if (isset($input_data['name'])) {
        $user->name = $input_data['name'];
    }
    if (isset($input_data['image'])) {
        $user->image = $this->storeFile($input_data['image'], 'images');
    }
    if (isset($input_data['email'])) {
        $user->email = $input_data['email'];
    }
    if (isset($input_data['university_number'])) {
        $user->university_number = $input_data['university_number'];
    }
    if (isset($input_data['section_id'])) {
        $user->section_id = $input_data['section_id'];
    }
    if (isset($input_data['academic_year'])) {
        $user->academic_year = $input_data['academic_year'];
    }



    // Save the updated user information
    if ($user->isDirty()) {
        $user->save();
    }

    $data=[
        'user'=>$user,
    ];

    $status_code=200;
    $msg="logged in";

    $result=[
        'data'=>$data,
        'status_code'=>$status_code,
        'msg'=>$msg
    ];
    return $result;

}









}

















?>

