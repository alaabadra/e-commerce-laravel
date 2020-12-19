<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function loginU(){
        $credentials=request(['email','password']);
        if(!$token_user = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'error'=>'Unauthorized',
                'status'=>401
                ]);
        }
        return $this->createNewToken($token_user);
    }
        /**
     * Get the token array structure.
     *
     * @param  string $token_user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function createNewToken($token_user){
        return response()->json([
            'access_token' => $token_user,
            'token_type' => 'bearer',
            'user_email'=>auth()->guard('api')->user()->email,
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);

    }

    public function getLogin(){
        return view('auth.login');
    }



    public function reg(){
        return view('auth.register');
    }

    public function regPost(Request $req){
         try{
        $data=$req->all();
        $userCount=User::where('email',$data['email'])->count();
        if($userCount>0){
            $user=User::where('email',$data['email'])->first();
            $confirmAccountUser=$user->status_confirmation=0;
            if($user->status_confirmation=0){
                return response()->json([
                    'status'=>400,
                    'message'=>'your email already exist , pls confirm it after that you can make login'
                ]);           
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'your are registered in this website , so you can make login direct'
                ]);  
            }
        }else{
            if($data['password_confirmation']==$data['password']){
                $emailUser=$data['email'];
                $messageData=['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($emailUser)];
                Mail::send('emails.confirmation',$messageData,function($message) use ($emailUser){
                    $message->to($emailUser)->subject('confirmation your  account');
                });
                DB::beginTransaction();
                User::insert(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'status_confirmation'=>0]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'check your email to activation your account'
                ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'there is some errors'
                ]);
            }
        }
          }catch(\Exception $ex){
         return response()->json([
             'status'=>500,
             'message'=>'There is something wrong, please try again'
         ]);  
     } 
        }
   
    

    public function confirmAccount($emailCode){
          if(filter_var($emailCode, FILTER_VALIDATE_EMAIL)) {
            $emailU=base64_destatus($emailCode);
            $userCount=User::where('email',$emailU)->count();
            if($userCount>0){
                $userDetails=User::where('email',$emailU)->first();
                if($userDetails->status_activation==1){
                    return response()->json([
                        'status'=>200,
                        'message'=>'your email account is already activated'
                    ]);
                }else{
                    User::where('email',$emailU)->update(['status_confirmation'=>1]);
                        //send welcome into our web to email
                    $userDetails=User::where('email',$emailU)->first();
                    $emailU=base64_destatus($emailCode);
                    $nameU=$userDetails->username;
                    $messageData=['email'=>$emailU,'name'=>$nameU];
                    Mail::send('emails.welcome',$messageData,function($message) use ($emailU){
                        $message->to($emailU)->subject('welcome to e-com website');
                    });
                    $loginRoute='user.post-login';                    
                    return response()->json([
                        'status'=>200,
                        'message'=>'your email account is activated, welcome into our website ,  now you make login from here:'.$loginRoute
                    ]);
                }
        
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                  ]);
            }
          }else {
             //invalid email
            return response()->json([
              'status' => 400,
              'message' => 'invalid email'
          ]);
          }
      }

    public function logout(){
        try{
        if(auth()->guard('api')->check()){
            auth()->guard('api')->logout();//delete from guard
            return response()->json([
                'status'=>200,
                'message'=>'logout successfully'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'you havent auth in this rout: you havnt session user to logout on it'
            ]);
            
        }
    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
}
