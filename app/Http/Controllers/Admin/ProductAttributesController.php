<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

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
            ProductAttribute::insert(['cart_id'=>$data['cart_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_attr_translation_of'=>0,'product_attr_name'=>$data['product_attr_name'],'product_attr_language'=>$data['product_attr_language'],'product_translation_of'=>$data['product_translation_of'],'product_attr_image'=>$data['product_attr_image'],'product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>'product_attr_quantity','product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>$data['product_attr_status'],'product_attr_status'=>$data['product_attr_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new ProductAttribute succefully'
            ]);
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
            $defaultproduct_attrCount= ProductAttribute::where(['product_attr_translation_of'=>0])->count();
            if($defaultproduct_attrCount!==0){//if exist any product_attr for the default language 
                $defaultCategories= ProductAttribute::where(['product_attr_translation_of'=>0])->get();
                $arrDefaultCategories=[];
                foreach($defaultCategories as $defaultproduct_attr){
                    $arrDefaultCategories.push($defaultproduct_attr->id);
                }
                $isContain=  $arrDefaultCategories.includes($data['product_attr_translation_of']);
                if($isContain){            
                    ProductAttribute::insert(['cart_id'=>$data['cart_id'],'language_id'=>$data['language_id'],'product_attr_translation_of'=>$data['product_attr_translation_of'],'product_attr_translation_of'=>0,'product_attr_name'=>$data['product_attr_name'],'product_attr_language'=>$data['product_attr_language'],'product_translation_of'=>$data['product_translation_of'],'product_attr_image'=>$data['product_attr_image'],'product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>'product_attr_quantity','product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>$data['product_attr_status'],'product_attr_status'=>$data['product_attr_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new ProductAttribute succefully'
            ]);
        }else{
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put product_attr_translation_of as this number because  this number not belongs to any id default product_attr'
            ]); 
        }
    }else{
        $routeStoreDefaultMainproduct_attr=route('/admin/categories/store_any_main_product_attr');
        return response()->json([
            'status'=>403,
            'message'=>'You cannt put product_attr_translation_of as this number , because until now not exist any product_attr for default language , so you can add a product_attr for default language from here  '.$routeStoreDefaultMainproduct_attr.'after that you can return into here to add your product_attr for default product_attr'
        ]);  
    }         
}else{
    return response()->json([
        'status'=>403,
        'message'=>'You cannt put product_attr_translation_of is 0 because this product_attr not for default language'
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
                $resultLanguage= forAnyLang($data['product_attr_translation_of'],$data['language_id']);
                DB::beginTransaction();
                ProductAttribute::where(['id'=>$id])->update(['cart_id'=>$data['cart_id'],'product_attr_translation_of'=>$data['product_attr_translation_of'],'language_id'=>$resultLanguage->id,'product_attr_name'=>$data['product_attr_name'],'product_attr_language'=>$data['product_attr_language'],'product_translation_of'=>$data['product_translation_of'],'product_attr_image'=>$data['product_attr_image'],'product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>'product_attr_quantity','product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>$data['product_attr_status'],'product_attr_status'=>$data['product_attr_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$productAttribute->name.'succefully'
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
                $defaultproduct_attrCount= ProductAttribute::where(['product_attr_translation_of'=>0])->count();
                if($defaultproduct_attrCount!==0){//if exist any product_attr for the default language 
                    $defaultCategories= ProductAttribute::where(['product_attr_translation_of'=>0])->get();
                    $arrDefaultCategories=[];
                    foreach($defaultCategories as $defaultproduct_attr){
                        $arrDefaultCategories.push($defaultproduct_attr->id);
                    }
                    $isContain=  $arrDefaultCategories.includes($data['product_attr_translation_of']);
                    if($isContain){
                DB::beginTransaction();
                ProductAttribute::where(['id'=>$id])->update(['cart_id'=>$data['cart_id'],'product_attr_translation_of'=>$data['product_attr_translation_of'],'language_id'=>$resultLanguage->id,'product_attr_name'=>$data['product_attr_name'],'product_attr_language'=>$data['product_attr_language'],'product_translation_of'=>$data['product_translation_of'],'product_attr_image'=>$data['product_attr_image'],'product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>'product_attr_quantity','product_attr_price'=>$data['product_attr_price'],'product_attr_quantity'=>$data['product_attr_quantity'],'product_attr_url'=>$data['product_attr_url'],'product_attr_type'=>$data['product_attr_type'],'product_attr_status'=>$data['product_attr_status'],'product_attr_status'=>$data['product_attr_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$productAttribute->name.'succefully'
                ]);
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put product_attr_translation_of as this number because  this number not belongs to any id default product_attr'
                ]); 
            }
        }else{
            $routeStoreDefaultMainproduct_attr=route('/admin/categories/store_any_main_product_attr');
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put product_attr_translation_of as this number , because until now not exist any product_attr for default language , so you can add a product_attr for default language from here  '.$routeStoreDefaultMainproduct_attr.'after that you can return into here to add your product_attr for default product_attr'
            ]);  
        }         
    }else{
        return response()->json([
            'status'=>403,
            'message'=>'You cannt put product_attr_translation_of is 0 because this product_attr not for default language'
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
