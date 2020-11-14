<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class BannersController extends Controller
{
    public function viewBanners(){
        $banners=Banner::get();
        return response()->json([
            'status'=>200,
            'message'=>$banners
        ]);
    }

    public function storeBannerForAnyLang(Request $req)
    {
        try{
            $data=$req->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['banner_translation_of'],$data['language_id']);
            if($resultLanguage==true){
            $defaultbannerCount= Banner::where(['banner_translation_of'=>null])->count();
            if($defaultbannerCount!==0){//if exist any banner for the default language 
                $defaultBanners= Banner::where(['banner_translation_of'=>null])->get();
                $arrDefaultBanners=[];
                foreach($defaultBanners as $defaultbanner){
                    array_push($arrDefaultBanners, $defaultbanner->id);
                }
                if($data['banner_translation_of']!==null){
                $isContain=  in_array($data['banner_translation_of'],$arrDefaultBanners);
                if($isContain){
                    $countNameBanner= Banner::where(['banner_description'=>$data['banner_description'],'language_id'=>$data['language_id'],'banner_translation_of'=>$data['banner_translation_of']])->count();
                    if($countNameBanner!==0){
                        return response()->json([
                            'status'=>200,
                            'message'=>'You cannt add this banner , because is exist same this banner for same this  language'
                        ]);
                    }else{
                        DB::commit();
                        $newBanner= new  Banner();
                        $newBanner->banner_status=$data['banner_status'];
                        $newBanner->banner_description=$data['banner_description'];
                        $newBanner->language_id=$data['language_id'];
                        $newBanner->banner_translation_of=$data['banner_translation_of'];
                        //upload image
                        $filePath="";
                        if($req->has('image')){
                            $filePath=uploadImage('banners',$req->photo);
                            $newBanner->banner_image=$filePath;
                        }
                        $newBanner->save();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Banner has added successfully'
                        ]);
                    }  
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put banner_translation_of as this number because  this number not belongs to any id default banner'
                    ]); 
                }
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'you can not add banner_translation_of=null because this route for adding banner not default'
                ]);
            }
            }else{
                $routeStoreDefaultBanner=route('admin.banner.store_banner_for_default_lang');
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put banner_translation_of as this number , because until now not exist any banner for default language , so you can add a banner for default language from here:'.$routeStoreDefaultBanner .'after that you can return into here to add your banner for default banner'
                ]);  
            }         
        }else{
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put banner_translation_of is null because this banner not for default language'
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
    public function storeBannerForDefaultLang(Request $req){
          
         try{
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            if($resultLangDefaultInTableLang!==0){
            $data=$req->all();
            DB::commit();
            //to avoid store default name banner  more than one
            $countNameBanner= Banner::where(['banner_description'=>$data['banner_description'],'language_id'=>$resultLangDefaultInTableLang->id,'banner_translation_of'=>0])->count();
            if($countNameBanner!==0){
                return response()->json([
                    'status'=>200,
                    'message'=>'You cannt add this banner , because is exist same this banner for same this default language'
                ]);
            }else{
                $newBanner= new  Banner();
                $newBanner->banner_status=$data['banner_status'];
                $newBanner->banner_image=$data['banner_image'];
                $newBanner->banner_description=$data['banner_description'];
                $newBanner->language_id=$resultLangDefaultInTableLang->id;
                $newBanner->banner_translation_of=null;
                //upload image
                $filePath="";
                if($req->has('image')){
                    $filePath=uploadImage('banners',$req->photo);
                    $newBanner->banner_image=$filePath;
                }
                $newBanner->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Banner has added successfully'
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

    public function updateBannerForDefaultLang(Request $req,$id=null){
        try{
           $editBanner=Banner::where(['id'=>$id])->first();
           if($editBanner){
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
                if($resultLangDefaultInTableLang!==0){
                    $data=$req->all();
                    DB::commit();
                    $countNameBanner= Banner::where(['banner_description'=>$data['banner_description'],['id','!=',$id],'language_id'=>$data['language_id'],'banner_translation_of'=>$data['banner_translation_of']])->count();
                    if($countNameBanner!==0){
                        return response()->json([
                            'status'=>200,
                            'message'=>'You cannt put this banner , because is exist same this banner for same this  language'
                        ]);
                    }else{
                        $editBanner->banner_status=$data['banner_status'];
                        $editBanner->banner_description=$data['banner_description'];
                        $editBanner->language_id=$resultLangDefaultInTableLang->id;
                        $editBanner->banner_translation_of=null;
                        //upload image
                        $filePath="";
                        if($req->has('image')){
                            $filePath=uploadImage('banners',$req->photo);
                            $editBanner->banner_image=$filePath;
                        }
                        $editBanner->save();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Banner has updated successfully'
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
                        'message'=>'You can not add this id banner because this not exist'
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
    public function updateBannerForAnyLang(Request $req,$id)
    {
     try{
        $editBanner=Banner::where(['id'=>$id])->first();
        if($editBanner){
            $data=$req->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['banner_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                $defaultbannerCount= Banner::where(['banner_translation_of'=>null])->count();
                if($defaultbannerCount!==0){//if exist any banner for the default language 
                    $defaultBanners= Banner::where(['banner_translation_of'=>null])->get();
                    $arrDefaultBanners=[];
                    foreach($defaultBanners as $defaultbanner){
                        array_push($arrDefaultBanners, $defaultbanner->id);
                    }
                    if($data['banner_translation_of']!==null){
                        $isContain=  in_array($data['banner_translation_of'],$arrDefaultBanners);
                        if($isContain){
                            $countNameBanner= Banner::where(['banner_description'=>$data['banner_description'],['id','!=',$id],'language_id'=>$data['language_id'],'banner_translation_of'=>$data['banner_translation_of']])->count();
                            if($countNameBanner!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this banner , because is exist same this banner for same this  language'
                                ]);
                            }else{
                                DB::commit();
                                $editBanner=Banner::where(['id'=>$id])->first();
                                $editBanner->banner_status=$data['banner_status'];
                                $editBanner->banner_description=$data['banner_description'];
                                $editBanner->banner_translation_of=$data['banner_translation_of'];
                                $editBanner->language_id=$data['language_id'];               
                                //upload image
                                $filePath="";
                                if($req->has('image')){
                                    $filePath=uploadImage('banners',$req->photo);
                                    $editBanner->banner_image=$filePath;
                                }
                                $editBanner->save();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'Banner has updated successfully'
                                ]); 
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put banner_translation_of as this number because  this number not belongs to any id default banner'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'status'=>400,
                            'message'=>'you can not add banner_translation_of=null because this route for adding banner not default'
                        ]);
                    }
                }else{
                    $routeStoreDefaultBanner=route('admin.banner.store_banner_for_default_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put banner_translation_of as this number , because until now not exist any banner for default language , so you can add a banner for default language from here:'.$routeStoreDefaultBanner. 'after that you can return into here to add your banner for default banner'
                    ]);  
                }         
        }else{
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put banner_translation_of is null because this banner not for default language'
            ]);
        }     

    }else{
        return response()->json([
            'status'=>400,
            'message'=>'You can not add this id banner because this not exist'
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

    public function deleteBanner($id=null){
        $banner=Banner::where(['id'=>$id])->first();
        $banner->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Banner has deleted successfully'
        ]);

    }
    public function showBanner($id){
    $banner= Banner::where(['id'=>$id])->first();
    return response()->json([
        'status'=>200,
        'message'=>$banner
    ]);
    }
}
