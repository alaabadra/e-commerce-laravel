<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function getLogin(){
        return view('auth.login');
    }

    public function loginPost(LoginRequest $req){
        $remember_me=$req->has('remember_me')? true :false;//if req has this name remember_me (check on checkbox) 
        if(auth()->guard('web')->attempt(['email'=>$req->input('email'),'password'=>$req->input('password')])){
            return redirect()->route('user.home');
        }
            return redirect()->back()->with(['errors'=>'هناك خطا بالبيانات']);

    }

    public function reg(){
        return view('auth.register');
    }

    public function regPost(RegRequest $req){
        $data=$req->all();
        $userCount=User::where('email',$data['email'])->count();
       // dd($userCount);
        if($userCount>0){
            return redirect('/user/login');
        }else{
          if($data['password_confirmation']==$data['password']){
            User::insert(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password'])]);
         
            return  redirect('/user/login');    
          }else{
            return  redirect('/user/reg');    
          }
        }
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();//delete from guard
            return  redirect('user/login');
        }else{
            return redirect()->back()->with(['errors'=>'you havent auth in this rout: you havnt session user to logout on it']);
        }
    }
}
