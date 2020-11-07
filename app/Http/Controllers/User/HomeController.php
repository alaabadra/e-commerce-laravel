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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //put putQuantityForProductBasedOnProdAttr
        $this->putQuantityForProductBasedOnProdAttr();
        return view('home');
    }
    

    public function putQuantityForProductBasedOnProdAttr(){
        $products=Product::get();
        $totalQuantitiesProdAttrs=0;
        $totalStatusProdAttrs=0;
        $totalPopularProdAttrs=0;
        $totalFeatureProdAttrs=0;
        foreach($products as $prod){
            $prodAttrs=ProductAttribute::where(['product_id'=>$prod->id])->get();
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
    public function search(Request $req){
        $data=$req->all();
        $searchProduct=Product::where(['product_name'=>$data['product_name']])->get();
        $searchSimilarProduct=SimilarProduct::where(['product_name'=>$data['product_name']])->get();
        $searchCategory=Category::where(['category_name'=>$data['category_name']])->get();
        $searchUser=User::where(['name'=>$data['name'],'email'=>$data['email']])->get();
        $searchAdmin=Admin::where(['name'=>$data['name'],'email'=>$data['email']])->get();
        return response()->json([
            'status'=>200,
            'datasearchProduct'=>$searchProduct,
            'datasearchSimilarProduct'=>$searchSimilarProduct,
            'datasearchCategory'=>$searchCategory,
            'datasearchUser'=>$searchUser,
            'datasearchAdmin'=>$searchAdmin
        ]);

    }
    public function viewLatestProducts(){
        try{
            $latestProducts=Product::latest()->paginate(6);
            return response()->json([
                'status'=>200,
                'message'=>$latestProducts
            ]);  
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
            return response()->json([
                'status'=>200,
                'message'=>$latestCategories
            ]);  
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
            return response()->json([
                'status'=>200,
                'message'=>$popularProducts
            ]);  
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
            return response()->json([
                'status'=>200,
                'message'=>$featureProducts
            ]);  
        }catch(\Exception $ex){
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);  
        }
    }
}
