<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;

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
            return response()->json([
                'status'=>200,
                'message'=>$categories
            ]);  
        }catch(\Exception $ex){
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);  
        }
        
    }
    
    public function mainCategories(){
        try{
            $mainCategories=Category::where(['parent_id'=>''])->paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$mainCategories
            ]);  
        }catch(\Exception $ex){
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);  
        }
    }
    public function getAllMainCategories(){//to show all it , if the person want into it through its route
        $allMainCategories=Category::where(['parent_id'=>''])->get();
        return response()->json([
            'status'=>200,
            'message'=>$allMainCategories
        ]);
    }
    public function getAllLangs(){//use in front to show list for all langs
     $getAllLangs=   Language::get();
        return response()->json([
            'status'=>200,
            'dataAllLanguages'=>$getAllLangs
        ]);  
    }
    public function getAllDefaultLangs(){//use in front to show list for default langs to select from it in form storeMainCategoryForAnyLang
        $getAllDefaultLangs=   Language::where(['category_translation_of'=>0])->get();
        return response()->json([
            'status'=>200,
            'dataAllDefaultLangs'=>$getAllDefaultLangs
        ]);  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getForCreateMainCategories()
    {
        $mainCategories=Category::where(['parent_id'=>''])->get();
        return response()->json([
            'status'=>200,
            'dataMainCategories'=>$mainCategories
        ]);  
    }
    public function getForCreateSubCategories()
    {
        $mainCategories=Category::where(['parent_id'=>''])->get();
        foreach($mainCategories as $mainCategory){
            $subCategories=Category::where(['parent_id'=>$mainCategory->id])->first();
            }
            return response()->json([
                'status'=>200,
                'dataSubCategories'=>$subCategories
            ]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMainCategoryForDefaultLang(Request $request)
    {
        try{
            $data=$request->all();
            
            $resultLangDefaultInTableLang= forDefaultLang();
                DB::beginTransaction(); 
                DB::commit();
                //category_translation_of=0 because this will be the defaule category
                Category::insert(['category_name'=>$data['category_name'],'parent_id'=>'','language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>0,'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                return response()->json([
                    'status'=>200,
                    'message'=>'added new category succefully'
                ]);
         

           
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }
    }

    public function storeMainCategoryForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            DB::commit();
            //data['language_id']: this value id from list the  langs   , $data['category_translation_of']: value id from list the categories that have the default langs
            $resultLanguage= forAnyLang($data['category_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                    $defaultCategoryCount= Category::where(['category_translation_of'=>0])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                    $defaultCategoryCount= Category::where(['category_translation_of'=>0])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                        $defaultCategories= Category::where(['category_translation_of'=>0])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            $arrDefaultCategories.push($defaultCategory->id);
                        }
                        $isContain=  $arrDefaultCategories.includes($data['category_translation_of']);
                        if($isContain){
                            Category::insert(['category_name'=>$data['category_name'],'parent_id'=>'','language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                            return response()->json([
                                'status'=>200,
                                'message'=>'added new category succefully'
                            ]);  
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                            ]); 
                        }
                }else{
                    $routeStoreDefaultMainCategory=route('/admin/categories/store_any_main_category');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of as this number , because until now not exist any category for default language , so you can add a category for default language from here  '.$routeStoreDefaultMainCategory.'after that you can return into here to add your category for default category'
                    ]);  
                }
                     
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of is 0 because this category not for default language'
                    ]); 
                }
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put this id for language , because this id not exist'
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


    public function storeSubCategoryForDefaultLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            
                if($data['parent_id']!==''){//if enter the parent_id : null
                    $mainCategoryCount= Category::where(['parent_id'=>''])->count();
                        if($mainCategoryCount!==0){//if exist any main category
                            $mainCategories= Category::where(['parent_id'=>''])->get();
                            $arrmainCategories=[];
                            foreach($mainCategories as $mainCategory){
                                $arrmainCategories.push($mainCategory->id);
                            }
                            $isContain=  $mainCategories.includes($data['parnet_id']);
                            if($isContain){
                                Category::insert(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>$data['category_translation_of'],'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new category succefully'
                                ]);  
                            }else{
                                return response()->json([
                                    'status'=>403,
                                    'message'=>'You cannt put parent_id as this number because  this number not belongs to any id main  category , you can see these ids from here'
                                ]); 
                            }
                        }else{
                            $routeStoreMainCategory='admin/categories/store_any_main_category';
                            return response()->json([
                                'status'=>500,
                                'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here to create main category it'.$routeStoreMainCategory.'after that you can return into this route'
                            ]);
                        }
                
                
                    }else{
                    $routeStoreMainCategory='admin/categories/store_any_main_category';
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt put parent_id is null , because this route for store sub category, not main category, you can stote category from here'.$routeStoreMainCategory
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

    public function storeSubCategoryForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['category_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                    $defaultCategoryCount= Category::where(['category_translation_of'=>0])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                        $defaultCategories= Category::where(['category_translation_of'=>0])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            $arrDefaultCategories.push($defaultCategory->id);
                        }
                        $isContain=  $arrDefaultCategories.includes($data['category_translation_of']);
                        if($isContain){
                            if($data['parent_id']!==''){//if enter the parent_id : null
                                $mainCategoryCount= Category::where(['parent_id'=>''])->count();
                                    if($mainCategoryCount!==0){//if exist any main category
                                        $mainCategories= Category::where(['parent_id'=>''])->get();
                                        $arrmainCategories=[];
                                        foreach($mainCategories as $mainCategory){
                                            $arrmainCategories.push($mainCategory->id);
                                        }
                                        $isContain=  $mainCategories.includes($data['parnet_id']);
                                        if($isContain){

                                            Category::insert(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                                            DB::commit();
                                           
                                            return response()->json([
                                                'status'=>200,
                                                'message'=>'added new category succefully'
                                            ]);  
                                        }else{
                                            return response()->json([
                                                'status'=>403,
                                                'message'=>'You cannt put parent_id as this number because  this number not belongs to any id main  category , you can see these ids from here'
                                            ]); 
                                        }
                                    }else{
                                        $routeStoreMainCategory='admin/categories/store_any_main_category';
                                        return response()->json([
                                            'status'=>500,
                                            'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here to create main category it'.$routeStoreMainCategory.'after that you can return into this route'
                                        ]);
                                    }
                            
                            
                                }else{
                                $routeStoreMainCategory='admin/categories/store_any_main_category';
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt put parent_id is null , because this route for store sub category, not main category, you can stote category from here'.$routeStoreMainCategory
                                ]);
                            }

                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                            ]); 
                        }
                }else{
                    $routeStoreDefaultMainCategory=route('/admin/categories/store_any_main_category');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of as this number , because until now not exist any category for default language , so you can add a category for default language from here  '.$routeStoreDefaultMainCategory.'after that you can return into here to add your category for default category'
                    ]);  
                }
                     
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of is 0 because this category not for default language'
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
    public function updateMainCategoryForDefaultLang(Request $request, $id)
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
                DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
                
                    DB::commit();
                    //category_translation_of=0 because this will be the defaule category
                    Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>'','language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>0,'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                    return response()->json([
                        'status'=>200,
                        'message'=>'updated'.$category->name.'succefully'
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

    public function updateMainCategoryForAnyLang(Request $request, $id)
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
            DB::beginTransaction();
            DB::commit();
            //data['language_id']: this value id from list the  langs   , $data['category_translation_of']: value id from list the categories that have the default langs
            $resultLanguage= forAnyLang($data['category_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                    $defaultCategoryCount= Category::where(['category_translation_of'=>0])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                    $defaultCategoryCount= Category::where(['category_translation_of'=>0])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                        $defaultCategories= Category::where(['category_translation_of'=>0])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            $arrDefaultCategories.push($defaultCategory->id);
                        }
                        $isContain=  $arrDefaultCategories.includes($data['category_translation_of']);
                        if($isContain){
                            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>'','language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                            return response()->json([
                                'status'=>200,
                                'message'=>'added new category succefully'
                            ]);  
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                            ]); 
                        }
                }else{
                    $routeupdateDefaultMainCategory=route('/admin/categories/update_any_main_category');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of as this number , because until now not exist any category for default language , so you can add a category for default language from here  '.$routeupdateDefaultMainCategory.'after that you can return into here to add your category for default category'
                    ]);  
                }
                     
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of is 0 because this category not for default language'
                    ]); 
                }
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put this id for language , because this id not exist'
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


    public function updateSubCategoryForDefaultLang(Request $request,$id)
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
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();

                if($data['parent_id']!==''){//if enter the parent_id : null
                    $mainCategoryCount= Category::where(['parent_id'=>''])->count();
                        if($mainCategoryCount!==0){//if exist any main category
                            $mainCategories= Category::where(['parent_id'=>''])->get();
                            $arrmainCategories=[];
                            foreach($mainCategories as $mainCategory){
                                $arrmainCategories.push($mainCategory->id);
                            }
                            $isContain=  $mainCategories.includes($data['parnet_id']);
                            if($isContain){
                                Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>$data['category_translation_of'],'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new category succefully'
                                ]);  
                            }else{
                                return response()->json([
                                    'status'=>403,
                                    'message'=>'You cannt put parent_id as this number because  this number not belongs to any id main  category , you can see these ids from here'
                                ]); 
                            }
                        }else{
                            $routeupdateMainCategory='admin/categories/update_any_main_category';
                            return response()->json([
                                'status'=>500,
                                'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here to create main category it'.$routeupdateMainCategory.'after that you can return into this route'
                            ]);
                        }
                
                
                    }else{
                    $routeupdateMainCategory='admin/categories/update_any_main_category';
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

    public function updateSubCategoryForAnyLang(Request $request,$id)
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
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['category_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                    $defaultCategoryCount= Category::where(['category_translation_of'=>0])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                    $defaultCategoryCount= Category::where(['category_translation_of'=>0])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                        $defaultCategories= Category::where(['category_translation_of'=>0])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            $arrDefaultCategories.push($defaultCategory->id);
                        }
                        $isContain=  $arrDefaultCategories.includes($data['category_translation_of']);
                        if($isContain){
                            if($data['parent_id']!==''){//if enter the parent_id : null
                                $mainCategoryCount= Category::where(['parent_id'=>''])->count();
                                    if($mainCategoryCount!==0){//if exist any main category
                                        $mainCategories= Category::where(['parent_id'=>''])->get();
                                        $arrmainCategories=[];
                                        foreach($mainCategories as $mainCategory){
                                            $arrmainCategories.push($mainCategory->id);
                                        }
                                        $isContain=  $mainCategories.includes($data['parnet_id']);
                                        if($isContain){
                                            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_url'=>$data['category_url'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                                            return response()->json([
                                                'status'=>200,
                                                'message'=>'added new category succefully'
                                            ]);  
                                        }else{
                                            return response()->json([
                                                'status'=>403,
                                                'message'=>'You cannt put parent_id as this number because  this number not belongs to any id main  category , you can see these ids from here'
                                            ]); 
                                        }
                                    }else{
                                        $routeupdateMainCategory='admin/categories/update_any_main_category';
                                        return response()->json([
                                            'status'=>500,
                                            'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here to create main category it'.$routeupdateMainCategory.'after that you can return into this route'
                                        ]);
                                    }
                            
                            
                                }else{
                                $routeupdateMainCategory='admin/categories/update_any_main_category';
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt put parent_id is null , because this route for update sub category, not main category, you can stote category from here'.$routeupdateMainCategory
                                ]);
                            }

                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                            ]); 
                        }
                }else{
                    $routeupdateDefaultMainCategory=route('/admin/categories/update_any_main_category');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of as this number , because until now not exist any category for default language , so you can add a category for default language from here  '.$routeupdateDefaultMainCategory.'after that you can return into here to add your category for default category'
                    ]);  
                }
                     
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of is 0 because this category not for default language'
                    ]); 
                }
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put this id for language , because this id not exist'
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
    public function destroy($id)
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
                    'message'=>'deleted this category succefully'
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
