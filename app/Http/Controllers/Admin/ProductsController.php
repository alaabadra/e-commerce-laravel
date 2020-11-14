<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        try{
            $products=Product::with(['category'])->paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$products
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
    public function storeProductForDefaultLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            if($resultLangDefaultInTableLang!==0){
                //upload image
                $filePath="";
                if($request->has('product_image')){
                    $filePath=uploadImage('admins',$request->product_image);
                }
                //to avoid store default name Product  more than one
                $countNameProduct= Product::where(['product_name'=>$data['product_name'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>null])->count();
                if($countNameProduct!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt add this Product , because is exist same this Product for same this default language'
                    ]);
                }else{
                    Product::insert(['category_id'=>$data['category_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>null,'product_name'=>$data['product_name'],'product_image'=>$filePath,'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status']]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'added new Product succefully'
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

    public function storeProductForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
             $resultLanguage= forAnyLang($data['product_translation_of'],$data['language_id']);
             if($resultLanguage==true){
                 $defaultProductCount= product::where(['product_translation_of'=>null])->count();
                 if($defaultProductCount!==0){//if exist any product for the default language 
                    $defaultProducts= product::where(['product_translation_of'=>null])->get();
                    $arrDefaultProducts=[];
                    foreach($defaultProducts as $defaultProduct){
                        array_push($arrDefaultProducts, $defaultProduct->id);
                    }
                        if($data['product_translation_of']!==null){
                            $isContain=  in_array($data['product_translation_of'],$arrDefaultProducts);
                            if($isContain){
                                //upload image
                                $filePath="";
                                if($request->has('product_image')){
                                    $filePath=uploadImage('product_images',$request->product_image);
                                }
                                $countNameProduct= Product::where(['product_name'=>$data['product_name'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of']])->count();
                                if($countNameProduct!==0){
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'You cannt add this product , because is exist same this product for same this  language'
                                    ]);
                                }else{
                                    Product::insert(['category_id'=>$data['category_id'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of'],'product_translation_of'=>0,'product_name'=>$data['product_name'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$data['product_image'],'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status'],'product_status'=>$data['product_status']]);
                                    DB::commit();
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'added new Product succefully'
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
                $routeStoreDefaultProduct=route('admin.product.store_product_for_any_lang');
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put product_translation_of as this number , because until now not exist any product for default language , so you can add a product for default language from here  '.$routeStoreDefaultProduct.'after that you can return into here to add your product for default product'
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProduct($id)
    {
        try{
            DB::beginTransaction();
            $product=Product::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$product
            ]);
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }

    }

    public function showProductsCategory($category_id)
    {
        try{
            DB::beginTransaction();
            $productsCategory=Product::where(['category_id'=>$category_id])->get();
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$productsCategory
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
    public function updateProductForDefaultLang(Request $request, $id)
    {
        try{
            $product=Product::find($id);
            if(!$product){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Product id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $resultLangDefaultInTableLang= forDefaultLang();
                if($resultLangDefaultInTableLang!==0){
                    $data=$request->all();
                    //upload image
                    $filePath="";
                    if($request->has('product_image')){
                        $filePath=uploadImage('admins',$request->product_image);
                    }
                    $countNameProduct= Product::where(['product_name'=>$data['product_name'],['id','!=',$id],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>$data['product_translation_of']])->count();
                    if($countNameProduct!==0){
                        return response()->json([
                            'status'=>200,
                            'message'=>'You cannt add this Product , because is exist same this Product for same this  language'
                        ]);
                    }else{
                        Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>null,'product_name'=>$data['product_name'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$data['product_image'],'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status'],'product_status'=>$data['product_status']]);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'updated'.$product->name.'succefully'
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
    public function updateProductForAnyLang(Request $request, $id)
    {
         try{
            $product=Product::find($id);
            if(!$product){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Product id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                 $resultLanguage= forAnyLang($data['product_translation_of'],$data['language_id']);
                 if($resultLanguage==true){
                $defaultproductCount= Product::where(['product_translation_of'=>null])->count();
                if($defaultproductCount!==0){//if exist any product for the default language 
                    $defaultProducts= Product::where(['product_translation_of'=>null])->get();
                    $arrDefaultProducts=[];
                    foreach($defaultProducts as $defaultProduct){
                        array_push($arrDefaultProducts, $defaultProduct->id);
                    }
                    if($data['product_translation_of']!==0){
                        $isContain=  in_array($data['product_translation_of'],$arrDefaultProducts);
                        if($isContain){
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
                                Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of'],'product_name'=>$data['product_name'],'product_image'=>$filePath,'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status']]);
                                DB::commit();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'updated'.$product->name.'succefully'
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
                    $routeStoreDefaultProduct=route('admin.product.store_product_for_any_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put product_translation_of as this number , because until now not exist any product for default language , so you can add a product for default language from here  '.$routeStoreDefaultProduct. 'after that you can return into here to add your product for default product'
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
    public function destroy($id)
    {
        try{
            $product=Product::find($id);
            if(!$product){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Product id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $product->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this Product succefully'
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
