<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function getAllProducts()
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
    public function getProductForSubCategories($category_id){
        try{
          $productForsubCategories=Product::where(['category_id'=>$category_id])->paginate(10);
          return response()->json([
              'status'=>200,
              'message'=>$productForsubCategories
          ]);
         }catch(\Exception $ex){
              return response()->json([
                  'status'=>500,
                  'message'=>'There is something wrong, please try again'
              ]);  
          } 
      }

}

