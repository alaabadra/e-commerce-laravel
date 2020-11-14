<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SimilarProduct;
use Illuminate\Http\Request;
use DB;
class SimilarProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        try{
            $similarProducts=SimilarProduct::with(['order','product'])->paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$similarProducts
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
    public function storeSimilarProductForDefaultLang(Request $request)
    {
     try{
        $data=$request->all();
        DB::beginTransaction();
        $resultLangDefaultInTableLang= forDefaultLang();
        if($resultLangDefaultInTableLang!==0){
            //upload image
            $filePath="";
            if($request->has('product_image')){
                $filePath=uploadImage('product_images',$request->product_image);
            }
            $countNameProduct= SimilarProduct::where(['product_name'=>$data['product_name'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>null])->count();
            if($countNameProduct!==0){
                return response()->json([
                    'status'=>200,
                    'message'=>'You cannt add this Product , because is exist same this Product for same this default language'
                ]);
            }else{
                SimilarProduct::insert(['product_id'=>$data['product_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>null,'product_name'=>$data['product_name'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$filePath,'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'added new Product successfully'
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

    public function storeSimilarProductForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['product_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                $defaultSimilarProductCount= SimilarProduct::where(['product_translation_of'=>null])->count();
                if($defaultSimilarProductCount!==0){//if exist any product for the default language 
                    $defaultCategories= SimilarProduct::where(['product_translation_of'=>null])->get();
                    $arrDefaultSimilarProducts=[];
                    foreach($defaultCategories as $defaultSimilarProduct){
                        array_push($arrDefaultSimilarProducts, $defaultSimilarProduct->id);
                    }
                    $isContain=  in_array($data['product_translation_of'],$arrDefaultSimilarProducts);
                    if($data['product_translation_of']!==null){
                        if($isContain){       
                            //upload image
                            $filePath="";
                            if($request->has('product_image')){
                                $filePath=uploadImage('product_images',$request->product_image);
                            }     
                            $countNameProduct= SimilarProduct::where(['product_name'=>$data['product_name'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of']])->count();
                            if($countNameProduct!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this product , because is exist same this product for same this  language'
                                ]);
                            }else{
                                SimilarProduct::insert(['product_id'=>$data['product_id'],'language_id'=>$data['language_id'],'product_translation_of'=>null,'product_name'=>$data['product_name'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$filePath,'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status']]);
                                DB::commit();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new SimilarProduct successfully'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put product_translation_of as this number because  this number not belongs to any id default product'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put product_translation_of is null because this product not for default language'
                        ]); 
                    }
                }else{
                    $routeStoreDefaultSimilarProd=route('admin.similar_product.store_similar_product_any_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put product_translation_of as this number , because until now not exist any product for default language , so you can add a product for default language from here:'.$routeStoreDefaultSimilarProd.'  after that you can return into here to add your product for default product'
                    ]);  
                }         
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put product_translation_of is null because this product not for default language'
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
    public function showSimilarProduct($id)
    {
        try{
            DB::beginTransaction();
            $similarProduct=SimilarProduct::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$similarProduct
            ]);
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }

    }
    public function showSimilarProducts($product_id)
    {
        try{
            DB::beginTransaction();
            $similarProducts=SimilarProduct::where(['product_id'=>$product_id])->first();
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$similarProducts
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

    public function updateSimilarProductForDefaultLang(Request $request, $id)
    {
        try{
            $SimilarProduct=SimilarProduct::find($id);
            if(!$SimilarProduct){
                return response()->json([
                    'status'=>404,
                    'message'=>'This SimilarProduct id not exist'
                ]);
            }else{
                $data=$request->all();
                $resultLangDefaultInTableLang= forDefaultLang();
                if($resultLangDefaultInTableLang!==0){
                DB::beginTransaction();
                $countNameProduct= Product::where(['product_name'=>$data['product_name'],['id','!=',$id],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>null])->count();
                if($countNameProduct!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt add this Product , because is exist same this Product for same this  language'
                    ]);
                }else{
                    //upload image
                    $filePath="";
                    if($request->has('product_image')){
                        $filePath=uploadImage('similar_products',$request->product_image);
                    }
                    SimilarProduct::where(['id'=>$id])->update(['product_id'=>$data['product_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>null,'product_name'=>$data['product_name'],'product_image'=>$filePath,'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status']]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'updated'.$SimilarProduct->name.'successfully'
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

    public function updateSimilarProductForAnyLang(Request $request, $id)
    {
         try{
            $SimilarProduct=SimilarProduct::find($id);
            if(!$SimilarProduct){
                return response()->json([
                    'status'=>404,
                    'message'=>'This SimilarProduct id not exist'
                ]);
            }else{
                $data=$request->all();
                 $resultLanguage= forAnyLang($data['product_translation_of'],$data['language_id']);
                 if($resultLanguage==true){
                $defaultSimilarProductCount= SimilarProduct::where(['product_translation_of'=>null])->count();
                if($defaultSimilarProductCount!==0){//if exist any product for the default language 
                    $defaultCategories= SimilarProduct::where(['product_translation_of'=>null])->get();
                    $arrDefaultSimilarProducts=[];
                    foreach($defaultCategories as $defaultSimilarProduct){
                        array_push($arrDefaultSimilarProducts, $defaultSimilarProduct->id);
                    }
                    if($data['product_translation_of']!==null){
                        $isContain=  in_array($data['product_translation_of'],$arrDefaultSimilarProducts);
                        if($isContain){
                            DB::beginTransaction();
                            $countNameProduct= Product::where(['product_name'=>$data['product_name'],['id','!=',$id],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of']])->count();
                            if($countNameProduct!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this Product , because is exist same this Product for same this  language'
                                ]);
                            }else{
                                //upload image
                                $filePath="";
                                if($request->has('product_image')){
                                    $filePath=uploadImage('product_images',$request->product_image);
                                }
                                SimilarProduct::where(['id'=>$id])->update(['product_id'=>$data['product_id'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of'],'product_name'=>$data['product_name'],'product_image'=>$filePath,'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status']]);
                                DB::commit();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'updated'.$SimilarProduct->name.'successfully'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put product_translation_of as this number because  this number not belongs to any id default product'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put product_translation_of is null because this product not for default language'
                        ]); 
                    } 
                }else{
                    $routeStoreDefaultSimilarProd=route('admin.similar_product.store_similar_product_default_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put product_translation_of as this number , because until now not exist any product for default language , so you can add a product  for default language from here:'.$routeStoreDefaultSimilarProd.' ,after that you can return into here to add your product for default product'
                    ]);  
                }         
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put product_translation_of is null because this product not for default language'
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
    public function delete($id)
    {
        try{
            $similarProduct=SimilarProduct::find($id);
            if(!$similarProduct){
                return response()->json([
                    'status'=>404,
                    'message'=>'This SimilarProduct id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $similarProduct->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this SimilarProduct successfully'
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
