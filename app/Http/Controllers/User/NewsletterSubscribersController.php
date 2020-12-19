<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsletterSubscribersController extends Controller
{
    public function checkSubscriberEmail(Request $req){
        try{
        if($req->isMethod('post')){
            $data=$req->all();
            $subscriberEmailCount=NewsletterSubscriber::where('email',$data['subscriber'])->count();//check if exist or no
            if($subscriberEmailCount>0){
                return response()->json([
                    'status'=>200,
                    'message'=>'this is email is exist, so you can not subscribe again'
                ]);
            }else{
                DB::beginTransaction();
                NewsletterSubscriber::insert(['email'=>$data['subscriber']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'added your subscriber successfully'
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
}
