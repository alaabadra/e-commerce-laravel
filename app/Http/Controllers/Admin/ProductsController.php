<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
            Product::insert(['category_id'=>$data['category_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>0,'product_name'=>$data['product_name'],'product_language'=>$data['product_language'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$data['product_image'],'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status'],'product_status'=>$data['product_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new Product succefully'
            ]);
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
                if($data['product_translation_of']!==0){
                    $defaultProductCount= product::where(['product_translation_of'=>0])->count();
                    if($defaultProductCount!==0){//if exist any product for the default language 
                        $defaultCategories= product::where(['product_translation_of'=>0])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultproduct){
                            $arrDefaultCategories.push($defaultproduct->id);
                        }
                        $isContain=  $arrDefaultCategories.includes($data['product_translation_of']);
                        if($isContain){
                            Product::insert(['category_id'=>$data['category_id'],'language_id'=>$data['language_id'],'product_translation_of'=>$data['product_translation_of'],'product_translation_of'=>0,'product_name'=>$data['product_name'],'product_language'=>$data['product_language'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$data['product_image'],'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status'],'product_status'=>$data['product_status']]);
                            DB::commit();
                            return response()->json([
                                'status'=>200,
                                'message'=>'added new Product succefully'
                            ]);
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put product_translation_of as this number because  this number not belongs to any id default product'
                            ]); 
                        }
                    }else{
                        $routeStoreDefaultMainproduct=route('/admin/categories/store_any_main_product');
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put product_translation_of as this number , because until now not exist any product for default language , so you can add a product for default language from here  '.$routeStoreDefaultMainproduct.'after that you can return into here to add your product for default product'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put product_translation_of is 0 because this product not for default language'
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
                $data=$request->all();
                DB::beginTransaction();
                $resultLangDefaultInTableLang= forDefaultLang();
                Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'language_id'=>$resultLangDefaultInTableLang->id,'product_translation_of'=>0,'product_name'=>$data['product_name'],'product_language'=>$data['product_language'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$data['product_image'],'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status'],'product_status'=>$data['product_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$product->name.'succefully'
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
                $defaultproductCount= Product::where(['product_translation_of'=>0])->count();
                if($defaultproductCount!==0){//if exist any product for the default language 
                    $defaultCategories= Product::where(['product_translation_of'=>0])->get();
                    $arrDefaultCategories=[];
                    foreach($defaultCategories as $defaultproduct){
                        $arrDefaultCategories.push($defaultproduct->id);
                    }
                    $isContain=  $arrDefaultCategories.includes($data['product_translation_of']);
                    if($isContain){
                Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'language_id'=>$data['langauge_id'],'product_translation_of'=>$data['product_translation_of'],'product_name'=>$data['product_name'],'product_language'=>$data['product_language'],'product_translation_of'=>$data['product_translation_of'],'product_image'=>$data['product_image'],'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>'product_quantity','product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_url'=>$data['product_url'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status'],'product_status'=>$data['product_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$product->name.'succefully'
                ]);
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put product_translation_of as this number because  this number not belongs to any id default product'
                ]); 
            }
        }else{
            $routeStoreDefaultMainproduct=route('/admin/categories/store_any_main_product');
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put product_translation_of as this number , because until now not exist any product for default language , so you can add a product for default language from here  '.$routeStoreDefaultMainproduct.'after that you can return into here to add your product for default product'
            ]);  
        }         
    }else{
        return response()->json([
            'status'=>403,
            'message'=>'You cannt put product_translation_of is 0 because this product not for default language'
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
