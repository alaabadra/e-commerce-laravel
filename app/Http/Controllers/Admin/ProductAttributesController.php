<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use DB;
class ProductAttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $productAttributes=ProductAttribute::with(['cart'])->paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$productAttributes
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
    public function storeProductAttrForDefaultLang(Request $request)
    {
     try{
        $data=$request->all();
        DB::beginTransaction();
        $resultLangDefaultInTableLang= forDefaultLang();
        if($resultLangDefaultInTableLang!==0){
            //upload image
            $filePath="";
            if($request->has('product_attr_image')){
                $filePath=uploadImage('product_attr_images',$request->product_attr_image);
            }
            $countNameProduct= ProductAttribute::where(['product_attr_name'=>$data['product_attr_name'],'language_id'=>$resultLangDefaultInTableLang->id,'product_attr_translation_of'=>null])->count();
            if($countNameProduct!==0){
                return response()->json([
                    'status'=>200,
                    'message'=>'You cannt add this Product , because is exist same this Product for same this default language'
                ]);
            }else{
                ProductAttribute::insert(['product_id'=>$data['product_id'],'cart_id'=>$data['cart_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_attr_translation_of'=>null,'product_attr_name'=>$data['product_attr_name'],'language_id'=>$data['language_id'],'product_attr_image'=>$filePath,'product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>$data['product_attr_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'added new ProductAttribute succefully'
                ]);
            }
        }else{
            $routeViewDashboard=route('admin.dashboard.generate_default_lang');
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again, because this website not contain on the default language , pls click here to generate it'.$routeViewDashboard.'after that you can return into this route'
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

    public function storeProductAttrForAnyLang(Request $request)
    {
         try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['product_attr_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                
            $defaultProductAttrsCount= ProductAttribute::where(['product_attr_translation_of'=>null])->count();
            if($defaultProductAttrsCount!==0){//if exist any product_attr for the default language 
                $defaultProductAttrs= ProductAttribute::where(['product_attr_translation_of'=>null])->get();
                $arrDefaultProductAttrs=[];
                    foreach($defaultProductAttrs as $defaultProductAttr){
                        array_push($arrDefaultProductAttrs, $defaultProductAttr->id);
                    }
                    $isContain=  in_array($data['product_attr_translation_of'],$arrDefaultProductAttrs);
                    if($data['product_attr_translation_of']!==0){
                        if($isContain){       
                            //upload image
                            $filePath="";
                            if($request->has('product_attr_image')){
                                $filePath=uploadImage('product_attr_images',$request->product_attr_image);
                            }     
                            $countNameProduct= ProductAttribute::where(['product_attr_name'=>$data['product_attr_name'],'language_id'=>$data['language_id'],'product_attr_translation_of'=>$data['product_attr_translation_of']])->count();
                            if($countNameProduct!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this product , because is exist same this product for same this  language'
                                ]);
                            }else{
                                ProductAttribute::insert(['product_id'=>$data['product_id'],'cart_id'=>$data['cart_id'],'language_id'=>$data['language_id'],'product_attr_translation_of'=>$data['product_attr_translation_of'],'product_attr_name'=>$data['product_attr_name'],'language_id'=>$data['language_id'],'product_attr_image'=>$filePath,'product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>$data['product_attr_status']]);
                                DB::commit();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new ProductAttribute succefully'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put product_attr_translation_of as this number because  this number not belongs to any id default product_attr'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put product_attr_translation_of is null because this product not for default language'
                        ]); 
                    }
                }else{
                    $routeStoreDefaultProductAttr=route('admin.product_attribute.store_product_attr_for_any_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put product_attr_translation_of as this number , because until now not exist any product_attr for default language , so you can add a product_attr for default language from here  after that you can return into here to add your product_attr for default product_attr'
                    ]);  
                }         
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put product_attr_translation_of is null because this product_attr not for default language'
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProductAttribute($id)
    {
        try{
            DB::beginTransaction();
            $productAttribute=ProductAttribute::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$productAttribute
            ]);
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }

    }

    public function showProductAttributes($product_id)
    {
        try{
            DB::beginTransaction();
            $productAttributes=ProductAttribute::where(['product_id'=>$product_id])->first();
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$productAttributes
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
    public function updateProductAttrForDefaultLang(Request $request, $id)
    {
        try{
            $productAttribute=ProductAttribute::find($id);
            if(!$productAttribute){
                return response()->json([
                    'status'=>404,
                    'message'=>'This ProductAttribute id not exist'
                ]);
            }else{
                $data=$request->all();
                $resultLangDefaultInTableLang= forDefaultLang();
                if($resultLangDefaultInTableLang!==0){
                DB::beginTransaction();
                $countNameProduct= ProductAttribute::where(['product_attr_name'=>$data['product_attr_name'],['id','!=',$id],'language_id'=>$resultLangDefaultInTableLang->id,'product_attr_translation_of'=>null])->count();
                if($countNameProduct!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt add this Product , because is exist same this Product for same this  language'
                    ]);
                }else{
                    //upload image
                    $filePath="";
                    if($request->has('product_attr_image')){
                        $filePath=uploadImage('product_attr_images',$request->product_attr_image);
                    }
                    ProductAttribute::where(['id'=>$id])->update(['product_id'=>$data['product_id'],'cart_id'=>$data['cart_id'],'product_attr_translation_of'=>null,'language_id'=>$resultLangDefaultInTableLang->id,'product_attr_name'=>$data['product_attr_name'],'product_attr_image'=>$filePath,'product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>$data['product_attr_status']]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'updated'.$productAttribute->name.'succefully'
                    ]);
                }
            }else{
                $routeViewDashboard=route('admin.dashboard.generate_default_lang');
                return response()->json([
                    'status'=>500,
                    'message'=>'There is something wrong, please try again, because this website not contain on the default language , pls click here to generate it'.$routeViewDashboard.'after that you can return into this route'
                    ]);
                    
                }
            }
            
         }catch(\Exception $ex){
             DB::rollback();
             return response()->json([
                 'status'=>500,
                 'message'=>'There is something wrong, please try again'
             ]);
         }
    }

    public function updateProductAttrForAnyLang(Request $request, $id)
    {
         try{
            $productAttribute=ProductAttribute::find($id);
            if(!$productAttribute){
                return response()->json([
                    'status'=>404,
                    'message'=>'This ProductAttribute id not exist'
                ]);
            }else{
                $data=$request->all();
                 $resultLanguage= forAnyLang($data['product_attr_translation_of'],$data['language_id']);
                 if($resultLanguage==true){
                $defaultProductAttrsCount= ProductAttribute::where(['product_attr_translation_of'=>null])->count();
                if($defaultProductAttrsCount!==0){//if exist any product_attr for the default language 
                    $defaultProductAttrs= ProductAttribute::where(['product_attr_translation_of'=>null])->get();
                    $arrDefaultProductAttrs=[];
                    foreach($defaultProductAttrs as $defaultProductAttr){
                        array_push($arrDefaultProductAttrs, $defaultProductAttr->id);
                    }
                    if($data['product_attr_translation_of']!==0){
                    $isContain=  in_array($data['product_attr_translation_of'],$arrDefaultProductAttrs);
                    if($isContain){
                        DB::beginTransaction();
                        $countNameProduct= ProductAttribute::where(['product_attr_name'=>$data['product_attr_name'],['id','!=',$id],'language_id'=>$data['language_id'],'product_attr_translation_of'=>$data['product_attr_translation_of']])->count();
                        if($countNameProduct!==0){
                            return response()->json([
                                'status'=>200,
                                'message'=>'You cannt add this Product , because is exist same this Product for same this  language'
                            ]);
                        }else{
                            //upload image
                            $filePath="";
                            if($request->has('product_attr_image')){
                                $filePath=uploadImage('admins',$request->product_attr_image);
                            }
                            ProductAttribute::where(['id'=>$id])->update(['product_id'=>$data['product_id'],'cart_id'=>$data['cart_id'],'language_id'=>$data['language_id'],'product_attr_name'=>$data['product_attr_name'],'language_id'=>$data['language_id'],'product_attr_translation_of'=>$data['product_attr_translation_of'],'product_attr_image'=>$filePath,'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_type'=>$data['product_attr_type'],'product_attr_price'=>$data['product_attr_price'],'product_attr_status'=>$data['product_attr_status']]);
                            DB::commit();
                            return response()->json([
                                'status'=>200,
                                'message'=>'updated'.$productAttribute->name.'succefully'
                            ]);
                        }
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put product_attr_translation_of as this number because  this number not belongs to any id default product_attr'
                        ]); 
                    }
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put product_attr_translation_of is null because this product not for default language'
                    ]); 
                } 
            }else{
                $routeStoreDefaultProductAttr=route('admin.product.store_product_for_any_lang');
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put product_attr_translation_of as this number , because until now not exist any product_attr for default language , so you can add a product_attr for default language from here: '.$routeStoreDefaultProductAttr.' ,after that you can return into here to add your product_attr for default product_attr'
                ]);  
            }         
        }else{
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put product_attr_translation_of is null because this product_attr not for default language'
            ]);
        }
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
            $productAttribute=ProductAttribute::find($id);
            if(!$productAttribute){
                return response()->json([
                    'status'=>404,
                    'message'=>'This ProductAttribute id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $productAttribute->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this ProductAttribute succefully'
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
