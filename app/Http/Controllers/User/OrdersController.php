<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function showOrder($order_id){
        $order=Order::where(['id'=>$order_id])->first();
        return response()->json([
            'status'=>200,
            'message'=>$order
        ]);
    }
}
