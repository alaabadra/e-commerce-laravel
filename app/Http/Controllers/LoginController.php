<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getLogin(){
        return view('admin.auth.login');
    }

    public function login(LoginRequest $req){
        $remember_me=$req->has('remember_me')? true :false;//if req has this name remember_me (check on checkbox) 
        if(auth()->guard('admin')->attempt(['email'=>$req->input('email'),'password'=>$req->input('password')])){

            return redirect()->route('admin.dashboard');
        }

         return redirect()->back()->with(['errors'=>'هناك خطا بالبيانات']);

    }
    
}
