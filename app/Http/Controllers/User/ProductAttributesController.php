<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributesController extends Controller
{
    public function getProductAttributes($product_id){
        try{
          $productAttributes=ProductAttribute::where(['product_id'=>$product_id])->paginate(10);
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


}
