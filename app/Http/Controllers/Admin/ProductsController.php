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
            if(!empty($products)){
                return response()->json([
                    'status'=>200,
                    'message'=>$products
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
                //upload image
                // $filePath="";
                // if($request->has('product_image')){
                //     $filePath=uploadImage('products',$request->product_image);
                // }
                //to avoid store default name Product  more than one
                    DB::beginTransaction();
                    // Product::insert(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_image'=>$filePath,'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_type'=>$data['product_type'],'product_status'=>$data['product_status']]);
                    Product::insert(['product_code'=>$data['product_code'],'product_brand'=>$data['product_brand'],'category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_price'=>$data['product_price'],'product_image'=>$data['product_image'],'product_quantity'=>$data['product_quantity'],'product_status'=>$data['product_status'],'product_weight'=>$data['product_weight'],'product_description'=>$data['product_description']]);

                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'added new Product successfully'
                    ]);
                
        //  }catch(\Exception $ex){
        //      DB::rollback();
        //      return response()->json([
        //          'status'=>500,
        //          'message'=>'There is something wrong, please try again'
        //      ]);
        //  }
     }

     public function showCategoryProduct($product_id){
        $product=Product::where(['id'=>$product_id])->first();
        
        if(!empty($product)){
            $categoryIdProduct=$product->category_id;
            $categoryProduct=Category::where(['id'=>$categoryIdProduct])->first();
            return response()->json([
                'status'=>200,
                'message'=>$categoryProduct
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
            ]);                

        }
     }

     public function showProductDataByCode($code_product){
         $dataProduct=Product::where(['product_code'=>$code_product])->with(['category'])->first();
         return response()->json([
             'status'=>200,
             'message'=>$dataProduct
         ]);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProduct($id)
    {
        // try{
            $product=Product::find($id);
            if(!empty($product)){
                return response()->json([
                    'status'=>200,
                    'message'=>$product
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);                

            }
        // }catch(\Exception $ex){
        //     return response()->json([
        //         'status'=>500,
        //         'message'=>'There is something wrong, please try again'
        //     ]);
        // }

    }

    public function showProductsCategory($category_id)
    {
        try{
            $productsCategory=Product::where(['category_id'=>$category_id])->get();
            if(!empty($productsCategory)){
                return response()->json([
                    'status'=>200,
                    'message'=>$productsCategory
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     //   try{
            $product=Product::find($id);
            if(!$product){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Product id not exist'
                ]);
            }else{
                    $data=$request->all();
                    //upload image
                    // $filePath="";
                    // if($request->has('product_image')){
                    //     $filePath=uploadImage('admins',$request->product_image);
                    // }

                            DB::beginTransaction();
                        Product::where(['id'=>$id])->update(['product_code'=>$data['product_code'],'product_brand'=>$data['product_brand'],'category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_image'=>$data['product_image'],'product_price'=>$data['product_price'],'product_quantity'=>$data['product_quantity'],'product_status'=>$data['product_status']]);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'updated'.$product->name.'successfully'
                        ]);
                    

            }
            
        // }catch(\Exception $ex){
        //     DB::rollback();
        //     return response()->json([
        //         'status'=>500,
        //         'message'=>'There is something wrong, please try again'
        //     ]);
        // }
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
                    'message'=>'deleted this Product successfully'
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
