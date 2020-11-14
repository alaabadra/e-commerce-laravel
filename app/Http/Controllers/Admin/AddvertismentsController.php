<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Addvertisment;
use Illuminate\Http\Request;
use DB;

class AddvertismentsController extends Controller
{
    public function viewAddvertisments(){
        $addvertisments=Addvertisment::get();
        return response()->json([
            'status'=>200,
            'message'=>$addvertisments
        ]);
    }

    public function storeAddvertismentForAnyLang(Request $req)
    {
        try{
            $data=$req->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['addvertisment_translation_of'],$data['language_id']);
            if($resultLanguage==true){
            $defaultaddvertismentCount= Addvertisment::where(['addvertisment_translation_of'=>null])->count();
            if($defaultaddvertismentCount!==null){//if exist any addvertisment for the default language 
                $defaultaddvertisments= Addvertisment::where(['addvertisment_translation_of'=>null])->get();
                $arrDefaultaddvertisments=[];
                foreach($defaultaddvertisments as $defaultaddvertisment){
                    array_push($arrDefaultaddvertisments, $defaultaddvertisment->id);
    
                }
                if($data['addvertisment_translation_of']!==null){
                $isContain=  in_array($data['addvertisment_translation_of'],$arrDefaultaddvertisments);
                if($isContain){
                    $countNameaddvertisment= Addvertisment::where(['addvertisment_description'=>$data['addvertisment_description'],'language_id'=>$data['language_id'],'addvertisment_translation_of'=>$data['addvertisment_translation_of']])->count();
                    if($countNameaddvertisment!==0){
                        return response()->json([
                            'status'=>200,
                            'message'=>'You cannt add this addvertisment , because is exist same this addvertisment for same this  language'
                        ]);
                    }else{
                        DB::commit();
                        $newaddvertisment= new  Addvertisment();
                        $newaddvertisment->addvertisment_status=$data['addvertisment_status'];
                        $newaddvertisment->addvertisment_description=$data['addvertisment_description'];
                        $newaddvertisment->addvertisment_image=$data['addvertisment_image'];
                        $newaddvertisment->language_id=$data['language_id'];
                        $newaddvertisment->addvertisment_translation_of=$data['addvertisment_translation_of'];
                        //upload image
                        $filePath="";
                        if($req->has('image')){
                            $filePath=uploadImage('addvertisments',$req->photo);
                            $newaddvertisment->addvertisment_image=$filePath;
                        }
                        $newaddvertisment->save();
                        return response()->json([
                            'status'=>200,
                            'message'=>'addvertisment has added successfully'
                        ]);
                    }  
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put addvertisment_translation_of as this number because  this number not belongs to any id default addvertisment'
                    ]); 
                }
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'you can not add addvertisment_translation_of==null because this route for adding addvertisment not default'
                ]);
            }
        }else{
            $routeStoreDefaultaddvertisment=route('admin.addvertisment.store_addvertisment_for_any_lang');
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put addvertisment_translation_of as this number , because until now not exist any addvertisment for default language , so you can add a addvertisment for default language from here after that you can return into here to add your addvertisment for default addvertisment'
            ]);  
        }         
    }else{
        return response()->json([
            'status'=>403,
            'message'=>'You cannt put addvertisment_translation_of is 0 because this addvertisment not for default language'
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
    public function storeAddvertismentForDefaultLang(Request $req){
          
         try{
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            if($resultLangDefaultInTableLang!==null){
                $data=$req->all();
                DB::commit();
                //to avoid store default name addvertisment  more than one
                $countNameaddvertisment= Addvertisment::where(['addvertisment_description'=>$data['addvertisment_description'],'language_id'=>$resultLangDefaultInTableLang->id,'addvertisment_translation_of'=>null])->count();
                if($countNameaddvertisment!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt add this addvertisment , because is exist same this addvertisment for same this default language'
                    ]);
                }else{
                    $newaddvertisment= new  Addvertisment();
                    $newaddvertisment->addvertisment_status=$data['addvertisment_status'];
                    $newaddvertisment->addvertisment_image=$data['addvertisment_image'];
                    $newaddvertisment->addvertisment_description=$data['addvertisment_description'];
                    $newaddvertisment->language_id=$resultLangDefaultInTableLang->id;
                    $newaddvertisment->addvertisment_translation_of=null;
                    //upload image
                    $filePath="";
                    if($req->has('image')){
                        $filePath=uploadImage('addvertisments',$req->photo);
                        $newaddvertisment->addvertisment_image=$filePath;
                    }
                    $newaddvertisment->save();
                    return response()->json([
                        'status'=>200,
                        'message'=>'addvertisment has added successfully'
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

    public function updateAddvertismentForDefaultLang(Request $req,$id=null){
        try{
           $editaddvertisment=Addvertisment::where(['id'=>$id])->first();
           if($editaddvertisment){
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            if($resultLangDefaultInTableLang!==null){
                $data=$req->all();
                DB::commit();
                $countNameaddvertisment= Addvertisment::where(['addvertisment_description'=>$data['addvertisment_description'],['id','!=',$id],'language_id'=>$data['language_id'],'addvertisment_translation_of'=>$data['addvertisment_translation_of']])->count();
                if($countNameaddvertisment!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt put this addvertisment , because is exist same this addvertisment for same this  language'
                    ]);
                }else{
                    $editaddvertisment->addvertisment_status=$data['addvertisment_status'];
                    $editaddvertisment->addvertisment_description=$data['addvertisment_description'];
                    $editaddvertisment->language_id=$resultLangDefaultInTableLang->id;
                    $editaddvertisment->addvertisment_translation_of=null;
                    //upload image
                     $filePath="";
                     if($req->has('image')){
                         $filePath=uploadImage('addvertisments',$req->photo);
                         $editaddvertisment->addvertisment_image=$filePath;
                     }
                    $editaddvertisment->save();
                    return response()->json([
                        'status'=>200,
                        'message'=>'addvertisment has updated successfully'
                    ]);   
                }  
                
            }else{
                $routeViewDashboard=route('admin.dashboard.generate_default_lang');
                return response()->json([
                    'status'=>500,
                    'message'=>'There is something wrong, please try again, because this website not contain on the default language , pls click here to generate it'.$routeViewDashboard.'after that you can return into this route'
                    ]);
                    
            }
            
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'You can not add this id addvertisment because this not exist'
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
    public function updateAddvertismentForAnyLang(Request $req,$id)
    {
        try{
            $editaddvertisment=Addvertisment::where(['id'=>$id])->first();
            if($editaddvertisment){
                $data=$req->all();
                DB::beginTransaction();
                $resultLanguage= forAnyLang($data['addvertisment_translation_of'],$data['language_id']);
                if($resultLanguage==true){
                    $defaultaddvertismentCount=Addvertisment::where(['addvertisment_translation_of'=>null])->count();
                    if($defaultaddvertismentCount!==null){//if exist any addvertisment for the default language 
                        $defaultaddvertisments= Addvertisment::where(['addvertisment_translation_of'=>null])->get();
                        $arrDefaultaddvertisments=[];
                        foreach($defaultaddvertisments as $defaultaddvertisment){
                            array_push($arrDefaultaddvertisments, $defaultaddvertisment->id);

                        }
                        if($data['addvertisment_translation_of']!==null){
                        $isContain=  in_array($data['addvertisment_translation_of'],$arrDefaultaddvertisments);
                            if($isContain){
                                $countNameaddvertisment= Addvertisment::where(['addvertisment_description'=>$data['addvertisment_description'],['id','!=',$id],'language_id'=>$data['language_id'],'addvertisment_translation_of'=>$data['addvertisment_translation_of']])->count();
                                if($countNameaddvertisment!==0){
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'You cannt add this addvertisment , because is exist same this addvertisment for same this  language'
                                    ]);
                                }else{
                                    DB::commit();
                                    $editaddvertisment=Addvertisment::where(['id'=>$id])->first();
                                    $editaddvertisment->addvertisment_status=$data['addvertisment_status'];
                                    $editaddvertisment->addvertisment_description=$data['addvertisment_description'];
                                    $editaddvertisment->addvertisment_translation_of=$data['addvertisment_translation_of'];
                                    $editaddvertisment->language_id=$data['language_id'];               
                                    //upload image
                                    $filePath="";
                                    if($req->has('image')){
                                        $filePath=uploadImage('users',$req->photo);
                                        $editaddvertisment->addvertisment_image=$filePath;
                                    }
                                    $editaddvertisment->save();
                                    return response()->json([
                                    'status'=>200,
                                    'message'=>'addvertisment has updated successfully'
                                    ]); 
                                }
                            }else{
                                return response()->json([
                                    'status'=>403,
                                    'message'=>'You cannt put addvertisment_translation_of as this number because  this number not belongs to any id default addvertisment'
                                ]); 
                            }
                    }else{
                        return response()->json([
                            'status'=>400,
                            'message'=>'you can not add addvertisment_translation_of==null because this route for adding addvertisment not default'
                        ]);
                    }
            }else{
                    $routeStoreDefaultaddvertisment=route('admin.addvertisment.store_addvertisment_for_any_lang');
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put addvertisment_translation_of as this number , because until now not exist any addvertisment for default language , so you can add a addvertisment for default language from here:'.$routeStoreDefaultaddvertisment.'after that you can return into here to add your addvertisment for default addvertisment'
                ]);  
            }         
        }else{
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put addvertisment_translation_of is 0 because this addvertisment not for default language'
            ]);
        }     

    }else{
        return response()->json([
            'status'=>400,
            'message'=>'You can not add this id addvertisment because this not exist'
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

    public function deleteAddvertisment($id=null){
        $addvertisment=Addvertisment::where(['id'=>$id])->first();
        $addvertisment->delete();
        return response()->json([
            'status'=>200,
            'message'=>'addvertisment has deleted successfully'
        ]);

}
public function showAddvertisment($id){
   $addvertisment= Addvertisment::where(['id'=>$id])->first();
   return response()->json([
    'status'=>200,
    'message'=>$addvertisment
   ]);
}
}
