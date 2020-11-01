<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function loginPost(LoginRequest $req){
            $remember_me=$req->has('remember_me')? true :false;//if req has this name remember_me (check on checkbox) 
            if(Auth::guard('admin')->attempt(['email'=>$req->input('email'),'password'=>$req->input('password')])){
                return  redirect('admin/dasboard');    
            }
             return redirect()->back()->with(['errors'=>'there is some errors']);

    }

    public function logout(){
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
            return  redirect('admin/login');    
        }else{
            return redirect()->back()->with(['errors'=>'you havent auth in this rout: you havnt session admin to logout on it']);
        }

    }
    
}
