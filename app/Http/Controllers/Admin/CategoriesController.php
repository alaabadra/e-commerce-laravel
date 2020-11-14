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
            $mainCategories=Category::where(['parent_id'=>null])->paginate(10);
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
        $allMainCategories=Category::where(['parent_id'=>null])->get();
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
        $getAllDefaultLangs=   Language::where(['category_translation_of'=>null])->get();
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
        $mainCategories=Category::where(['parent_id'=>null])->get();
        return response()->json([
            'status'=>200,
            'dataMainCategories'=>$mainCategories
        ]);  
    }
    public function getForCreateSubCategories()
    {
        $mainCategories=Category::where(['parent_id'=>null])->get();
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
            if($resultLangDefaultInTableLang!==0){
                DB::beginTransaction(); 
                //upload image
                 $filePath="";
                 if($request->has('category_image')){
                     $filePath=uploadImage('categories',$request->category_image);
                 }
                //to avoid store default name category  more than one
               $countNameCategory= Category::where(['category_name'=>$data['category_name'],'parent_id'=>null,'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>null])->count();
                if($countNameCategory!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt add this category , because is exist same this category for same this default language'
                    ]);
                }else{
                    Category::insert(['category_name'=>$data['category_name'],'parent_id'=>null,'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>null,'category_description'=>$data['category_description'],'category_image'=>$filePath,'category_status'=>$data['category_status']]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'added new category succefully'
                    ]);
                }     
            }else{
                $routeViewDashboard=route('admin.dashboard.generate_default_lang');
                return response()->json([
                    'status'=>500,
                    'message'=>'There is something wrong, please try again, because this website not contain on the default language , pls click here to generate it'.$routeViewDashboard.'after that you can return into this route'
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

    public function storeMainCategoryForAnyLang(Request $request)
    {
       try{
            $data=$request->all();
            DB::beginTransaction();
            DB::commit();
           //data['language_id']: this value id from list the  langs   , $data['category_translation_of']: value id from list the categories that have the default langs
           $resultLanguage= forAnyLang($data['category_translation_of'],$data['language_id']);
            if($resultLanguage==true){     
                    $defaultCategoryCount= Category::where(['category_translation_of'=>null,'parent_id'=>null])->count();
                    if($defaultCategoryCount!==0){//if exist any main category for the default language 
                        $defaultCategories= DB::table('categories')->where(['category_translation_of'=>null,'parent_id'=>null])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            array_push($arrDefaultCategories, $defaultCategory->id);
                        }
                        if($data['category_translation_of']!==0){
                            $isContain=  in_array($data['category_translation_of'],$arrDefaultCategories);
                            if($isContain){
                                $countNameCategory= Category::where(['category_name'=>$data['category_name'],'parent_id'=>null,'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of']])->count();
                                if($countNameCategory!==0){
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'You cannt add this category , because is exist same this category for same this  language'
                                    ]);
                                }else{
                                    $filePath="";
                                    if($request->has('category_image')){
                                        $filePath=uploadImage('categories',$request->category_image);
                                    }
                                    Category::insert(['category_name'=>$data['category_name'],'parent_id'=>null,'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_description'=>$data['category_description'],'category_image'=>$filePath,'category_status'=>$data['category_status']]);
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'added new category succefully'
                                    ]);  
                                }
                            }else{
                                return response()->json([
                                    'status'=>403,
                                    'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                                ]); 
                            }
                        }else{
                            return response()->json([
                                'status'=>400,
                                'message'=>'you can not add category_translation_of=null because this route for adding category not default'
                            ]);
                        }
                    }else{
                        $routeStoreDefaultMainCategory=route('admin.categorie.store_default_main_category');
                    return response()->json([
                        'status'=>40300,
                        'message'=>'until now not exist any category for default language , so you can add a category for default language from here:'.$routeStoreDefaultMainCategory.'after that you can return into here to add your category for default category'
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
           if($resultLangDefaultInTableLang!==0){
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
                            //check if the sub category have same name , smae lang and trnsaltion for it is 0 (default) , such as adding name category have same lang and this default as that in db in addition at : have same name  category in sub
                            $countNameCategory= Category::where(['category_name'=>$data['category_name'],['parent_id','!=',null],'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>null])->count();
                            if($countNameCategory!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this category , because is exist same this category for same this default language'
                                ]);
                            }else{
                                $filePath="";
                                if($request->has('category_image')){
                                    $filePath=uploadImage('categories',$request->category_image);
                                }
                                $category=new Category();
                                $category->category_name=$data['category_name'];
                                $category->parent_id=$data['parent_id'];
                                $category->language_id=$resultLangDefaultInTableLang->id;
                                $category->category_translation_of=0;
                                $category->category_description=$data['category_description'];
                                $category->category_image=$filePath;
                                $category->category_status=$data['category_status'];
                                $category->save();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new category succefully'
                                ]);  
                            }
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
                            'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here:'.$routeStoreMainCategory.'to create main category it after that you can return into this route'
                        ]);
                    }
                }else{
                    $routeStoreMainCategory=route('admin.categorie.store_any_main_category');
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt put parent_id is null , because this route for store sub category, not main category, you can stote category from here'
                    ]);
                }
          
            }else{
                $routeViewDashboard=route('admin.dashboard.generate_default_lang');
                return response()->json([
                    'status'=>500,
                    'message'=>'There is something wrong, please try again, because this website not contain on the default language , pls click here to generate it'.$routeViewDashboard.'after that you can return into this route'
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
                    $defaultCategoryCount= Category::where(['category_translation_of'=>null,['parent_id','!=',null]])->count();
                    if($defaultCategoryCount!==0){//if exist any sub category for the default language 
                        $defaultCategories= Category::where(['category_translation_of'=>null,['parent_id','!=',null]])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            array_push($arrDefaultCategories, $defaultCategory->id);
                          }
                        $isContain=  in_array($data['category_translation_of'],$arrDefaultCategories);
                        if($isContain){
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
                                            $countNameCategory= Category::where(['category_name'=>$data['category_name'],['parent_id','!=',null],'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of']])->count();
                                            if($countNameCategory!==0){
                                                return response()->json([
                                                    'status'=>200,
                                                    'message'=>'You cannt add this category , because is exist same this category for same this default  language'
                                                ]);
                                            }else{
                                                $filePath="";
                                                if($request->has('category_image')){
                                                    $filePath=uploadImage('categories',$request->category_image);
                                                }
                                                Category::insert(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_description'=>$data['category_description'],'category_image'=>$filePath,'category_status'=>$data['category_status']]);
                                                DB::commit();
                                                return response()->json([
                                                    'status'=>200,
                                                    'message'=>'added new category succefully'
                                                ]);  
                                            }
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
                                            'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here:'.$routeStoreMainCategory.'to create main category it after that you can return into this route'
                                        ]);
                                    }
                            
                            
                                }else{
                                $routeStoreMainCategory=route('admin.categorie.store_any_main_category');
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt put parent_id is null , because this route for store sub category, not main category, you can stote category from here:'.$routeStoreMainCategory
                                ]);
                            }

                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                            ]); 
                        }
                }else{
                     $routeStoreDefaultSubCategory=route('admin.categorie.store_default_sub_category');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of as this number , because until now not exist any category for default language , so you can add a category for default language from here :' .$routeStoreDefaultSubCategory.' after that you can return into here to add your category for default category'
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
                    if($resultLangDefaultInTableLang!==0){
                        $countNameCategory= Category::where(['category_name'=>$data['category_name'],'parent_id'=>null,['id','!=',$id],'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>null])->count();
                        if($countNameCategory!==0){
                            return response()->json([
                        'status'=>200,
                        'message'=>'You cannt update this category as this , because is exist same this category for same this default language'
                        ]);
                        }else{
                            DB::commit();
                            //upload image
                            $filePath="";
                            if($request->has('category_image')){
                                $filePath=uploadImage('categories',$request->category_image);
                            }
                            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>null,'language_id'=>$data['language_id'],'category_translation_of'=>null,'category_description'=>$data['category_description'],'category_image'=>$filePath,'category_status'=>$data['category_status']]);
                            return response()->json([
                                'status'=>200,
                                'message'=>'updated'.$category->name.'succefully'
                            ]);
                        }
                    }else{
                        $routeViewDashboard=route('admin.dashboard.generate_default_lang');
                        return response()->json([
                            'status'=>500,
                            'message'=>'There is something wrong, please try again, because this website not contain on the default language , pls click here to generate it'.$routeViewDashboard.'after that you can return into this route'
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
                    $defaultCategoryCount= Category::where(['category_translation_of'=>null,'parent_id'=>null])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                        $defaultCategories= Category::where(['category_translation_of'=>null,'parent_id'=>null])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            array_push($arrDefaultCategories, $defaultCategory->id);
                        }
                        if($data['category_translation_of']!==0){
                            $isContain=  in_array($data['category_translation_of'],$arrDefaultCategories);
                            if($isContain){
                                $countNameCategory= Category::where(['category_name'=>$data['category_name'],['id','!=',$id],'parent_id'=>null,'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of']])->count();
                                    if($countNameCategory!==0){
                                        return response()->json([
                                            'status'=>200,
                                            'message'=>'You cannt put this category , because is exist same this category for same this  language'
                                        ]);
                                    }else{
                                        Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>null,'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_description'=>$data['category_description'],'category_image'=>$data['category_image'],'category_status'=>$data['category_status']]);
                                        return response()->json([
                                            'status'=>200,
                                            'message'=>'updated category succefully'
                                        ]); 
                                    }
                                
                            }else{
                                return response()->json([
                                    'status'=>403,
                                    'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                                ]); 
                            }
                        }else{
                            return response()->json([
                                'status'=>400,
                                'message'=>'you can not put category_translation_of=null because this route for adding category not default'
                            ]);
                        }
                    }else{
                        $routeupdateDefaultMainCategory=route('admin.categorie.update_main_category_for_default_lang',$id);
                        return response()->json([
                            'status'=>403,
                            'message'=>'until now not exist any category for default language , so you can add a category for default language from here  '.$routeupdateDefaultMainCategory.'after that you can return into here to add your category for default category'
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
                        //check if the sub category have same name , smae lang and trnsaltion for it is 0 (default) , such as adding name category have same lang and this default as that in db in addition at : have same name  category in sub
                        $countNameCategory= Category::where(['category_name'=>$data['category_name'],['id','!=',$id],['parent_id','!=',null],'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>null])->count();
                        if($countNameCategory!==0){
                            return response()->json([
                                'status'=>200,
                                'message'=>'You cannt add this category , because is exist same this category for same this default language'
                            ]);
                        }else{
                            $filePath="";
                            if($request->has('category_image')){
                                $filePath=uploadImage('categories',$request->category_image);
                            }
                            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'language_id'=>$resultLangDefaultInTableLang->id,'category_translation_of'=>$data['category_translation_of'],'category_description'=>$data['category_description'],'category_image'=>$filePath,'category_status'=>$data['category_status']]);
                            return response()->json([
                                'status'=>200,
                                'message'=>'updated new category succefully'
                            ]);
                        }  
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
                    $defaultCategoryCount= Category::where(['category_translation_of'=>null])->count();
                    if($defaultCategoryCount!==0){//if exist any category for the default language 
                        $defaultCategories= Category::where(['category_translation_of'=>null])->get();
                        $arrDefaultCategories=[];
                        foreach($defaultCategories as $defaultCategory){
                            array_push($arrDefaultCategories, $defaultCategory->id);
                        }
                        $isContain=  in_array($data['parent_id'],$arrDefaultCategories);
                        if($isContain){
                            $countNameCategory= Category::where(['category_name'=>$data['category_name'],['parent_id','!=',null],'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of']])->count();
                            if($countNameCategory!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this category , because is exist same this category for same this default  language'
                                ]);
                            }else{
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
                                            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'language_id'=>$data['language_id'],'category_translation_of'=>$data['category_translation_of'],'category_description'=>$data['category_description'],'category_image'=>$filePath,'category_status'=>$data['category_status']]);
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
                                        $routeupdateMainCategory=route('admin.categorie.update_main_category_for_any_lang',$id);
                                        return response()->json([
                                            'status'=>500,
                                            'message'=>'There is something wrong, please try again, because this website not contain on any main category , pls click here to create main category it'.$routeupdateMainCategory.'after that you can return into this route'
                                        ]);
                                    }
                                }else{
                                    $routeupdateMainCategory=route('admin.categorie.update_main_category_for_any_lang',$id);
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'You cannt put parent_id is null , because this route for update sub category, not main category, you can stote category from here'.$routeupdateMainCategory
                                    ]);
                                }
                                
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put category_translation_of as this number because  this number not belongs to any id default category'
                            ]); 
                        }
                }else{
                    $routeupdateDefaultMainCategory=route('admin.categorie.update_main_category_for_any_lang',$id);
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put category_translation_of as this number , because until now not exist any category for default language , so you can add a category for default language from here  '.$routeupdateDefaultMainCategory.'after that you can return into here to add your category for default category'
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
