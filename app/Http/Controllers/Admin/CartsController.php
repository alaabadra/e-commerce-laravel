<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartsController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $carts=Cart::paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$carts
            ]);  
        }catch(\Exception $ex){
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);  
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            Cart::insert(['cart_color'=>$data['cart_color'],'cart_size'=>$data['cart_size'],'cart_status'=>$data['cart_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new cart succefully'
            ]);
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }
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
            DB::beginTransaction();
            $cart=Cart::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$cart
            ]);
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $cart=Cart::find($id);
            if(!$cart){
                return response()->json([
                    'status'=>404,
                    'message'=>'This cart id not exist'
                ]);
            }else{
                
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
            $cart=Cart::find($id);
            if(!$cart){
                return response()->json([
                    'status'=>404,
                    'message'=>'This cart id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Cart::where(['id'=>$id])->update(['cart_color'=>$data['cart_color'],'cart_size'=>$data['cart_size'],'cart_status'=>$data['cart_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$cart->name.'succefully'
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
    public function destroy($id)
    {
        try{
            $cart=Cart::find($id);
            if(!$cart){
                return response()->json([
                    'status'=>404,
                    'message'=>'This admin id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $cart->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this cart succefully'
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
}
