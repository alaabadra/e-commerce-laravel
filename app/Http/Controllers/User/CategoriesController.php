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
        return response()->json([
            'status'=>500,
            'message'=>$mainCategories
        ]);
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
          return response()->json([
              'status'=>500,
              'message'=>$subCategories
          ]);
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
          return response()->json([
              'status'=>500,
              'message'=>$subCategoriesForMainCategory
          ]);
         }catch(\Exception $ex){
              return response()->json([
                  'status'=>500,
                  'message'=>'There is something wrong, please try again'
              ]);  
          } 
      }
      public function showCategory($category_id){
        $category=  Category::where(['id'=>$category_id])->fisrt();
        $contentTheCatogory=Product::where(['category_id'=>$category_id])->get();//all products that it in thid category
        return response()->json([
            'status'=>200,
            'infoCategory'=>$category,
            'contentTheCatogory'=>$contentTheCatogory
        ]);
      }
      
}
