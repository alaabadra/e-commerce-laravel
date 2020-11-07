<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Couponcode;
use App\Models\Order;
use Illuminate\Http\Request;

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
    public function storeCouponcodeForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $languageIdCount=Language::where(['id'=>$data['language_id']])->count();
            if($languageIdCount!==0){//if id language taht from request : isexit in table language or not                 
                if($data['coupon_translation_of']!==0){
                    $defaultCouponCount= Coupon::where(['coupon_translation_of'=>0])->count();
                    if($defaultCouponCount!==0){//if exist any coupon for the default language 
                        $defaultCategories= coupon::where(['coupon_translation_of'=>0])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultcoupon){
                            $arrDefaultCategories.push($defaultcoupon->id);
                        }
                        $isContain=  $arrDefaultCategories.includes($data['coupon_translation_of']);
                        if($isContain){
                            DB::commit();
                            Couponcode::insert(['order_id'=>$data['order_id'],'language_id'=>$data['language_id'],'coupon_translation_of'=>$data['coupon_translation_of'],'coupon_code'=>$data['coupon_code'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_expiry_date'=>$data['coupon_code_expiry_date'],'coupon_code_status'=>$data['coupon_code_status']]);
                            
                            return response()->json([
                                'status'=>200,
                                'message'=>'added new couponcode succefully'
                            ]);
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put coupon_translation_of as this number because  this number not belongs to any id default coupon'
                            ]); 
                        }
                    }else{
                        $routeStoreDefaultMaincoupon=route('/admin/categories/store_any_main_coupon');
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put coupon_translation_of as this number , because until now not exist any coupon for default language , so you can add a coupon for default language from here  '.$routeStoreDefaultMaincoupon.'after that you can return into here to add your coupon for default coupon'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put coupon_translation_of is 0 because this coupon not for default language'
                    ]); 
                }
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put this id for language , because this id not exist'
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

    public function storeCouponcodeForDefaultLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            Couponcode::insert(['order_id'=>$data['order_id'],'language_id'=>$resultLangDefaultInTableLang->id,'coupon_translation_of'=>0,'coupon_code'=>$data['coupon_code'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_expiry_date'=>$data['coupon_code_expiry_date'],'coupon_code_status'=>$data['coupon_code_status']]);
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
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$couponcode
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function updateCouponcodeForDefaultLang(Request $request,$id)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            Couponcode::where(['id'=>$id])->update(['order_id'=>$data['order_id'],'language_id'=>$resultLangDefaultInTableLang->id,'coupon_translation_of'=>0,'coupon_code'=>$data['coupon_code'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_expiry_date'=>$data['coupon_code_expiry_date'],'coupon_code_status'=>$data['coupon_code_status']]);
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



    public function updateCouponcodeForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['coupon_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                if($data['coupon_translation_of']!==0){
                    $defaultCouponCount= Coupon::where(['coupon_translation_of'=>0])->count();
                    if($defaultCouponCount!==0){//if exist any coupon for the default language 
                        $defaultCategories= coupon::where(['coupon_translation_of'=>0])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultcoupon){
                            $arrDefaultCategories.push($defaultcoupon->id);
                        }
                        $isContain=  $arrDefaultCategories.includes($data['coupon_translation_of']);
                        if($isContain){
                            Couponcode::insert(['order_id'=>$data['order_id'],'language_id'=>$data['language_id'],'coupon_translation_of'=>$data['coupon_translation_of'],'coupon_code'=>$data['coupon_code'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_amount_type'=>$data['coupon_code_amount'],'coupon_code_expiry_date'=>$data['coupon_code_expiry_date'],'coupon_code_status'=>$data['coupon_code_status']]);
                            DB::commit();
                            return response()->json([
                                'status'=>200,
                                'message'=>'updated couponcode succefully'
                            ]);
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put coupon_translation_of as this number because  this number not belongs to any id default coupon'
                            ]); 
                        }
                    }else{
                        $routeStoreDefaultMaincoupon=route('/admin/categories/store_any_main_coupon');
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put coupon_translation_of as this number , because until now not exist any coupon for default language , so you can add a coupon for default language from here  '.$routeStoreDefaultMaincoupon.'after that you can return into here to add your coupon for default coupon'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put coupon_translation_of is 0 because this coupon not for default language'
                    ]); 
                }
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put this id for language , because this id not exist'
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
