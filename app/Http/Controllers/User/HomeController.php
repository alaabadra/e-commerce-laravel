<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\SimilarProduct;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try{
        //put putQuantityForProductBasedOnProdAttr
        $this->putQuantityForProductBasedOnProdAttr();
        return response()->json([
            'status'=>200,
            'message'=>'welcome into our website'
        ]);
    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    

    public function putQuantityForProductBasedOnProdAttr(){
        try{
        $products=Product::get();
        $totalQuantitiesProdAttrs=0;
        $totalStatusProdAttrs=0;
        $totalPopularProdAttrs=0;
        $totalFeatureProdAttrs=0;
        foreach($products as $prod){
            $prodAttrs=ProductAttribute::where(['product_id'=>$prod->id])->get();
            if(!empty($prodAttrs)){
                foreach($prodAttrs as $prodAttr){
                    
                    $totalQuantitiesProdAttrs+=$prodAttr->quantity;//total all quanutities for this product
                    
                    $totalStatusProdAttrs+=$prodAttr->product_status;//total all status for this product
                    $totalPopularProdAttrs+=$prodAttr->product_popular;//total all popular for this product
                    $totalFeatureProdAttrs+=$prodAttr->product_feature;//total all feature for this product
                
                }
                $prod->quantity=$totalQuantitiesProdAttrs;    
                $prod->product_status=$totalStatusProdAttrs;
                $prod->product_popular=$totalPopularProdAttrs;
                $prod->product_feature=$totalFeatureProdAttrs;
            }
        }
    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function searchProduct(Request $req){
        try{
        $data=$req->all();
        $searchProduct=Product::where(['product_name'=>$data['product_name']])->get();
        return response()->json([
            'status'=>200,
            'datasearchProduct'=>$searchProduct
        ]);
    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function searchCategory(Request $req){
        try{
        $data=$req->all();
        $searchCategory=Category::where(['category_name'=>$data['category_name']])->get();
        return response()->json([
            'status'=>200,
            'datasearchCategory'=>$searchCategory
        ]);
    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function searchUser(Request $req){
        try{
        $data=$req->all();
        $searchUser=User::where(['name'=>$data['name'],'email'=>$data['email']])->get();
        return response()->json([
            'status'=>200,
            'datasearchUser'=>$searchUser
        ]);
    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function searchAdmin(Request $req){
        try{
        $data=$req->all();
        $searchAdmin=Admin::where(['name'=>$data['name'],'email'=>$data['email']])->get();
        return response()->json([
            'status'=>200,
            'datasearchAdmin'=>$searchAdmin
        ]);
    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function viewLatestProducts(){
        try{
            $latestProducts=Product::latest()->paginate(6);
            if(!empty($latestProducts)){
                return response()->json([
                'status'=>200,
                'message'=>$latestProducts
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
    public function viewLatestCategories(){
        try{
            $latestCategories=Category::latest()->paginate(6);
            if(!empty($latestCategories)){
                return response()->json([
                'status'=>200,
                'message'=>$latestCategories
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

    public function viewPopularProducts(){
        try{
            $popularProducts=Product::where(['product_popular'=>1])->paginate(6);
            if(!empty($popularProducts)){
                return response()->json([
                    'status'=>200,
                    'message'=>$popularProducts
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

    public function viewFeatureProducts(){
        try{
            $featureProducts=Product::where(['product_feature'=>1])->paginate(6);
            if(!empty($featureProducts)){
                return response()->json([
                'status'=>200,
                'message'=>$featureProducts
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
}
