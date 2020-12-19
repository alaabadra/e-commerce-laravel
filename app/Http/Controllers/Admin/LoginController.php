<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class LoginController extends Controller
{
    
        /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginA(){
        $credentials=request(['email','password']);
        if(!$token=auth()->guard('admin')->attempt($credentials)){
           // dd($token);
            return response()->json([
                'error'=>'Invalid email or password',
                'status'=>401
                ]);
        }
        return $this->createNewToken($token);
    }
        /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'admin_email'=>auth()->guard('admin')->user()->email,
            'expires_in' => auth()->guard('admin')->factory()->getTTL() * 60
        ]);

    }
    public function logoutA(){
        auth()->logout();
        return response()->json([
            'msg'=>'user successfully logged out'
        ]);
    }
    public function getLoginAdmin(){
        return view('admin.auth.login');
    }

    
    
    public function postLoginAdmin(LoginRequest $req){
            $remember_me=$req->has('remember_me')? true :false;//if req has this name remember_me (check on checkbox) 
            $data=$req->all();
            if(Auth::guard('admin')->attempt([$data['email'],'password'=>bcrypt($data['password'])])){
                return response()->json([
                    'status'=>200,
                    'message'=>'login admin successfully'
                ]);
            }
            return response()->json([
                'status'=>400,
                'message'=>'there is some errors'
            ]);
    }


    public function logoutAdmin(){
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
            return response()->json([
                'status'=>200,
                'message'=>'logout admin successfully'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'you havent auth in this rout: you havnt session admin to logout on it'
            ]);
        }

    }
    
}
