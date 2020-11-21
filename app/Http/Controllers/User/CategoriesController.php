<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getMainCategories(){
      try{
        $mainCategories=Category::where(['parent_id'=>''])->paginate(10);
        if(!empty($mainCategories)){
            return response()->json([
                'status'=>500,
                'message'=>$mainCategories
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

    public function getSubCategories(){
        try{
          $subCategories=Category::where('parent_id','!=','')->paginate(10);
          if(!empty($subCategories)){
              return response()->json([
                  'status'=>500,
                  'message'=>$subCategories
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

      public function getSubCategoriesForMainCategory($category_id){
        try{
          $subCategoriesForMainCategory=Category::where(['parent_id'=>$category_id])->paginate(10);
          if(!empty($subCategoriesForMainCategory)){
              return response()->json([
                  'status'=>500,
                  'message'=>$subCategoriesForMainCategory
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
      public function showCategory($category_id){
          try{
        $category=  Category::where(['id'=>$category_id])->fisrt();
        if(!empty($category)){
            $contentTheCatogory=Product::where(['category_id'=>$category_id])->get();//all products that it in thid category
            if(!empty($contentTheCatogory)){
                return response()->json([
                    'status'=>200,
                    'infoCategory'=>$category,
                    'contentTheCatogory'=>$contentTheCatogory
                ]);
                
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);
            }
            
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
