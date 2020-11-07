<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function ShowReviewers($product_attr_id=null){
        $revsCount=Review::where(['product_attr_id'=>$product_attr_id])->count();
        if($revsCount!==0){
          $revs=Review::where(['product_attr_id'=>$product_attr_id])->get();
          return response()->json([
            'status'=>200,
            'message'=>$revs
          ]);  
        }else{
            return response()->json([
                'status'=>200,
                'message'=>'there is no reviews on this product'
              ]);  
        }
        }
}
