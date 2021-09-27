<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $token =  $user->createToken('MyApp')-> accessToken; 
          
            $data = [
                'user' => $user->only(['nim', 'username','nama_lengkap']),
                'token' =>  $token
            ];

            return $this->success( $data,"login success");
        } 
        else{ 
            return $this->error("username atau password salah" , 200);
        } 
    }

    public function register(RegisterRequest $request)
    {
        
        $validated = $request->validated();

        if($validated){

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
    
            return $this->success('',"Berhasil Mendaftarkan Akun");
        }
       
      
    }

    public function ubahPassword(Request $request)
    {
        try {
            if (Hash::check($request->pass_lama, Auth::user()->password)) {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->pass_baru);
                $user->save();
                return $this->success('', "berhasil ubah password");
            } else {
                return $this->error("Password Lama Tidak cocok" , 200);
            }
        } catch (\Throwable $th) {
            return $this->error("Terjadi Kesalahan", 400);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $user =  User::where('nim', $request->nim)->where('username',$request->username)->first();
      
            if($user==null){
                return $this->error("NIM atau username anda tidak tepat ",200);
            }
            
            $user->password = Hash::make('123456');
            $user->save();

            return $this->success("", "Password anda berhasil di reset menjadi 123456");
        } catch (\Throwable $th) {
            return $this->error("NIM atau username anda tidak tepat ".$th, 200);
        }
       
      
    }

    public function logout()
    {
        try {
            Auth::user()->token()->delete(); 
            return $this->success('',"user berhasil logout");
        } catch (\Throwable $th) {
            return $this->error("Terjadi Kesalahan", 400);
        }
      
    }

    
   
}