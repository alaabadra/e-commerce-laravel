<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function showOrder($order_id){
        try{
        $order=Order::where(['id'=>$order_id])->first();
        if(!empty($order)){
            return response()->json([
            'status'=>200,
            'message'=>$order
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
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