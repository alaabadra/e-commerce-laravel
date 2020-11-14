<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Couponcode;
use App\Models\Order;
use Illuminate\Http\Request;
use DB;
class CouponcodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $couponcodes=Couponcode::with('order')->get();
            return response()->json([
                'status'=>200,
                'message'=>$couponcodes
            ]);  
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
        try{
            $data=$request->all();
            DB::beginTransaction();
            Couponcode::insert(['order_id'=>$data['order_id'],'coupon_code'=>$data['coupon_code'],'coupon_code_amount'=>$data['coupon_code_amount'],'coupon_code_amount_type'=>$data['coupon_code_amount_type'],'coupon_code_expiry_date'=>$data['coupon_code_expiry_date'],'coupon_code_status'=>$data['coupon_code_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new couponcode succefully'
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
            $couponcode=Couponcode::find($id);
            if($couponcode){
               DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$couponcode
            ]);  
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is not exist this id'
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



    public function update(Request $request,$id)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
             $resultLangDefaultInTableLang= forDefaultLang();
            Couponcode::where(['id'=>$id])->update(['order_id'=>$data['order_id'],'coupon_code'=>$data['coupon_code'],'coupon_code_amount'=>$data['coupon_code_amount'],'coupon_code_amount_type'=>$data['coupon_code_amount_type'],'coupon_code_expiry_date'=>$data['coupon_code_expiry_date'],'coupon_code_status'=>$data['coupon_code_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'updated new couponcode succefully'
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try{
            $couponcode=Couponcode::find($id);
            if(!$couponcode){
                return response()->json([
                    'status'=>404,
                    'message'=>'This couponcode id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $couponcode->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this couponcode succefully'
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
