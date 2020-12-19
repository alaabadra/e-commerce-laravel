<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Config;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allCategories()
    {
        try{
            $categories=Category::paginate(10);
            if(!empty($categories)){
               return response()->json([
                'status'=>200,
                'message'=>$categories
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
    
    public function mainCategories(){
        try{
            $mainCategories=Category::where(['parent_id'=>null])->paginate(10);
            if(!empty($mainCategories)){
                return response()->json([
                'status'=>200,
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
    public function getAllMainCategories(){//to show all it , if the person want into it through its route
        try{
        $allMainCategories=Category::where(['parent_id'=>null])->get();
        if(!empty($allMainCategories)){
           return response()->json([
            'status'=>200,
            'message'=>$allMainCategories
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
    public function getAllLangs(){//use in front to show list for all langs
        try{
     $getAllLangs=   Language::get();
     if(!empty($getAllLangs)){
        return response()->json([
            'status'=>200,
            'dataAllLanguages'=>$getAllLangs
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
    public function getAllDefaultLangs(){//use in front to show list for default langs to select from it in form storeMainCategoryForAnyLang
        try{
        $getAllDefaultLangs=   Language::where(['category_translation_of'=>null])->get();
        if(!empty($getAllDefaultLangs)){
            return response()->json([
            'status'=>200,
            'dataAllDefaultLangs'=>$getAllDefaultLangs
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getForCreateMainCategories()
    {
        try{
        $mainCategories=Category::where(['parent_id'=>null])->get();
        if(!empty($mainCategories)){
            return response()->json([
                'status'=>200,
                'dataMainCategories'=>$mainCategories
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

    public function subCategories()
    {
       // try{
        $subCategories=Category::where('parent_id','!=',null)->get();
        if(!empty($subCategories)){
            
            return response()->json([
                'status'=>200,
                'dataSubCategories'=>$subCategories
            ]); 
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
            ]);
        }
    // }catch(\Exception $ex){
    //     return response()->json([
    //         'status'=>500,
    //         'message'=>'There is something wrong, please try again'
    //     ]);  
    // }
    }
    public function getForCreateSubCategories($mainCategoryId)
    {
       // try{
        $subCategories=Category::where(['parent_id'=>$mainCategoryId])->get();
        if(!empty($subCategories)){
            
            return response()->json([
                'status'=>200,
                'dataSubCategories'=>$subCategories
            ]); 
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
            ]);
        }
    // }catch(\Exception $ex){
    //     return response()->json([
    //         'status'=>500,
    //         'message'=>'There is something wrong, please try again'
    //     ]);  
    // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMainCategory(Request $request)
    {
        // try{
            $data=$request->all();
            dd($request);
                DB::beginTransaction(); 
                Category::insert(['category_name'=>$data['category_name'],'parent_id'=>null,'category_status'=>$data['category_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'added new main category successfully'
                ]);

        // }catch(\Exception $ex){
        //     DB::rollback();
        //     return response()->json([
        //         'status'=>500,
        //         'message'=>'There is something wrong, please try again'
        //     ]);
        // }
    }



    public function storeSubCategory(Request $request)
    {
        try{
            $data=$request->all();
                if($data['parent_id']!==null){//if enter the parent_id : null
                    $mainCategoryCount= Category::where(['parent_id'=>null])->count();
                    if($mainCategoryCount!==0){//if exist any main category
                        $mainCategories= Category::where(['parent_id'=>null])->get();
                        $arrmainCategories=[];
                        foreach($mainCategories as $mainCategory){
                            array_push($arrmainCategories, $mainCategory->id);
                        }
                        $isContain=  in_array($data['parent_id'],$arrmainCategories);
                        if($isContain){
                                $filePath="";
                                if($request->has('category_image')){
                                    $filePath=uploadImage('categories',$request->category_image);
                                }
                                DB::beginTransaction();
                                $category=new Category();
                                $category->category_name=$data['category_name'];
                                $category->parent_id=$data['parent_id'];
                                $category->category_status=$data['category_status'];
                                $category->save();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new sub category successfully'
                                ]); 
                                DB::commit(); 
                            
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put parent_id as this number because  this number not belongs to any id main  category , you can see these ids from here'
                            ]); 
                        }
                    }else{
                        $routeStoreMainCategory=route('admin.categorie.store_any_main_category');
                        return response()->json([
                            'status'=>500,
                            'message'=>'There is something wrong, because this website not contain on any main category , pls click here:'.$routeStoreMainCategory.'to create main category it after that you can return into this route'
                        ]);
                    }
                }else{
                    $routeStoreMainCategory=route('admin.categories.store_main_category');
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt put parent_id is null , because this route for store sub category, not main category, you can stote category from here'
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            DB::beginTransaction();
            $category=Category::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$category
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMainCategory(Request $request, $id)
    {
        try{
            $category=Category::find($id);
            if(!$category){
                return response()->json([
                    'status'=>404,
                    'message'=>'This category id not exist'
                ]);
            }else{
                $data=$request->all();
                            DB::commit();
                            //upload image
                            $filePath="";
                            if($request->has('category_image')){
                                $filePath=uploadImage('categories',$request->category_image);
                            }
                            DB::beginTransaction();
                            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>null,'language_id'=>$data['language_id'],'category_translation_of'=>null,'category_description'=>$data['category_description'],'category_image'=>$filePath,'category_status'=>$data['category_status']]);
                            DB::commit();
                            return response()->json([
                                'status'=>200,
                                'message'=>'updated'.$category->name.'successfully'
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



    public function updateSubCategory(Request $request,$id)
    {
         try{
            $category=Category::find($id);
            if(!$category){
                return response()->json([
                    'status'=>404,
                    'message'=>'This category id not exist'
                ]);
            }else{
            $data=$request->all();
            if($data['parent_id']!==null){//if enter the parent_id : null
                $mainCategoryCount= Category::where(['parent_id'=>null])->count();
                if($mainCategoryCount!==0){//if exist any main category
                    $mainCategories= Category::where(['parent_id'=>null])->get();
                    $arrmainCategories=[];
                    foreach($mainCategories as $mainCategory){
                        array_push($arrmainCategories, $mainCategory->id);
                    }
                    $isContain=  in_array($data['parent_id'],$arrmainCategories);
                    if($isContain){
                                DB::beginTransaction();
                            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'category_status'=>$data['category_status']]);
                            DB::commit();
                            return response()->json([
                                'status'=>200,
                                'message'=>'updated new category successfully'
                            ]);
                          
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put parent_id as this number because  this number not belongs to any id main  category , you can see these ids from here'
                        ]); 
                    }
                }else{
                    $routeupdateMainCategory=route('admin.categorie.update_main_category_for_any_lang');
                    return response()->json([
                        'status'=>500,
                        'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here to create main category it'.$routeupdateMainCategory.'after that you can return into this route'
                    ]);
                }
            }else{
                $routeupdateMainCategory=route('admin.categorie.update_main_category_for_any_lang');
                return response()->json([
                    'status'=>200,
                    'message'=>'You cannt put parent_id is null , because this route for update sub category, not main category, you can stote category from here'.$routeupdateMainCategory
                ]);
            }
           
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
    public function delete($id)
    {
        try{
            $category=Category::find($id);
            if(!$category){
                return response()->json([
                    'status'=>404,
                    'message'=>'This category id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $category->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this category successfully'
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
