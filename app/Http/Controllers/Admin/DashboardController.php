<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use DB;
class DashboardController extends Controller
{
    public function index(){
      $this->putQuantityForProductBasedOnProdAttr();
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
    
}
