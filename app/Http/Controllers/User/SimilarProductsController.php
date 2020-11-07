<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\SimilarProduct;
use Illuminate\Http\Request;

class SimilarProductsController extends Controller
{
    public function getSimilarProducts($product_id){
        try{
          $similarProduct=SimilarProduct::where(['product_id'=>$product_id])->paginate(10);
          return response()->json([
              'status'=>500,
              'message'=>$similarProduct
          ]);
         }catch(\Exception $ex){
              return response()->json([
                  'status'=>500,
                  'message'=>'There is something wrong, please try again'
              ]);  
          } 
      }
}
