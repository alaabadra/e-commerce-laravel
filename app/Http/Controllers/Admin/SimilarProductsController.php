<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\SimilarProduct;
use Illuminate\Http\Request;

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
            $similarProducts=SimilarProduct::with(['order','productAttribute'])->paginate(10);
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
    public function store(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            SimilarProduct::insert(['order_id'=>$data['order_id'],'product_attr_id'=>$data['product_attr_id']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new SimilarProduct succefully'
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $similarProduct=SimilarProduct::find($id);
            if(!$similarProduct){
                return response()->json([
                    'status'=>404,
                    'message'=>'This SimilarProduct id not exist'
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
            $similarProduct=SimilarProduct::find($id);
            if(!$similarProduct){
                return response()->json([
                    'status'=>404,
                    'message'=>'This SimilarProduct id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                SimilarProduct::where(['id'=>$id])->update(['order_id'=>$data['order_id'],'product_attr_id'=>$data['product_attr_id']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$similarProduct->name.'succefully'
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
                    'message'=>'deleted this SimilarProduct succefully'
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
