<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $orders=Order::with(['delivery','user','product'])->paginate(10);
            if(!empty($orders)){
                return response()->json([
                    'status'=>200,
                    'message'=>$orders
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try{
            $data=$request->all();
            DB::beginTransaction();
            Order::insert(['order_payment_method'=>$data['order_payment_method'],'order_code'=>$data['order_code'],'user_id'=>$data['user_id'],'delivery_id'=>$data['delivery_id'],'order_price'=>$data['order_price'],'order_status'=>$data['order_status'],'order_payment_method'=>$data['order_payment_method']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new Order succefully'
            ]);
        //  }catch(\Exception $ex){
        //      DB::rollback();
        //      return response()->json([
        //          'status'=>500,
        //          'message'=>'There is something wrong, please try again'
        //      ]);
        //  }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        try{
            $order=Order::find($id);
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
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $order=Order::find($id);
            if(!$order){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Order id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Order::where(['id'=>$id])->update(['order_payment_method'=>$data['order_payment_method'],'order_number'=>$data['order_number'],'user_id'=>$data['user_id'],'delivery_id'=>$data['delivery_id'],'order_price'=>$data['order_price'],'order_status'=>$data['order_status'],'order_shipping_tax'=>$data['order_shipping_tax'],'order_shipping_cost'=>$data['order_shipping_cost']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$order->name.'succefully'
                ]);
            }
            
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //try{
            $order=Order::find($id);
            if(!$order){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Order id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $order->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this Order succefully'
                ]);
            }
            
        // }catch(\Exception $ex){
        //     return response()->json([
        //         'status'=>500,
        //         'message'=>'There is something wrong, please try again'
        //     ]);
        // }
    }
}
