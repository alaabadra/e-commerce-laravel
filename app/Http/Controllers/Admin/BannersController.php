<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $defaultbannerCount= Banner::where(['banner_translation_of'=>0])->count();
            if($defaultbannerCount!==0){//if exist any banner for the default language 
                $defaultCategories= Banner::where(['banner_translation_of'=>0])->get();
                $arrDefaultCategories=[];
                foreach($defaultCategories as $defaultbanner){
                    $arrDefaultCategories.push($defaultbanner->id);
                }
                $isContain=  $arrDefaultCategories.includes($data['banner_translation_of']);
                if($isContain){
                    DB::commit();
                    $newBanner= new  Banner();
                    $newBanner->banner_status=$data['banner_status'];
                    $newBanner->banner_title=$data['banner_title'];
                    $newBanner->banner_decription=$data['banner_decription'];
                    $newBanner->language_id=$data['language_id'];
                    $newBanner->banner_translation_of=$data['banner_translation_of'];
                    //upload image
                    $filePath="";
                    if($req->has('image')){
                        $filePath=uploadImage('users',$req->photo);
                        $newBanner->banner_image=$filePath;
                    }
                    $newBanner->save();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Banner has added successfully'
                    ]);  
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put banner_translation_of as this number because  this number not belongs to any id default banner'
                    ]); 
                }
            }else{
                $routeStoreDefaultMainbanner=route('/admin/categories/store_any_main_banner');
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put banner_translation_of as this number , because until now not exist any banner for default language , so you can add a banner for default language from here  '.$routeStoreDefaultMainbanner.'after that you can return into here to add your banner for default banner'
                ]);  
            }         
        }else{
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put banner_translation_of is 0 because this banner not for default language'
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
            $data=$req->all();
            DB::commit();
            $newBanner= new  Banner();
            $newBanner->banner_status=$data['banner_status'];
            $newBanner->banner_title=$data['banner_title'];
            $newBanner->banner_decription=$data['banner_decription'];
            $newBanner->language_id=$resultLangDefaultInTableLang->id;
            $newBanner->banner_translation_of=0;
            //upload image
            $filePath="";
            if($req->has('image')){
                $filePath=uploadImage('users',$req->photo);
                $newBanner->banner_image=$filePath;
            }
            $newBanner->save();
            return response()->json([
                'status'=>200,
                'message'=>'Banner has added successfully'
            ]);     

            
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);
        }
    }

    public function updateBannerForDefault(Request $req,$id=null){
        try{
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            $data=$req->all();
            DB::commit();
            $editBanner=Banner::where(['id'=>$id])->first();
            $editBanner->banner_status=$data['banner_status'];
            $editBanner->banner_title=$data['banner_title'];
            $editBanner->banner_decription=$data['banner_decription'];
            $editBanner->language_id=$resultLangDefaultInTableLang->id;
           
            //upload image
            $filePath="";
            if($req->has('image')){
                $filePath=uploadImage('users',$req->photo);
                $editBanner->banner_image=$filePath;
            }
            $editBanner->save();
            return response()->json([
                'status'=>200,
                'message'=>'Banner has updated successfully'
            ]);     

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
        $data=$req->all();
        DB::beginTransaction();
        $resultLanguage= forAnyLang($data['banner_translation_of'],$data['language_id']);
        if($resultLanguage==true){
        $defaultbannerCount= Banner::where(['banner_translation_of'=>0])->count();
        if($defaultbannerCount!==0){//if exist any banner for the default language 
            $defaultCategories= Banner::where(['banner_translation_of'=>0])->get();
            $arrDefaultCategories=[];
            foreach($defaultCategories as $defaultbanner){
                $arrDefaultCategories.push($defaultbanner->id);
            }
            $isContain=  $arrDefaultCategories.includes($data['banner_translation_of']);
            if($isContain){
                DB::commit();
                $editBanner=Banner::where(['id'=>$id])->first();
                $editBanner->banner_status=$data['banner_status'];
                $editBanner->banner_title=$data['banner_title'];
                $editBanner->banner_decription=$data['banner_decription'];
                $editBanner->banner_translation_of=$data['banner_translation_of'];
                $editBanner->banner_language_id=$data['banner_language_id'];               
                //upload image
                $filePath="";
                if($req->has('image')){
                    $filePath=uploadImage('users',$req->photo);
                    $editBanner->banner_image=$filePath;
                }
                $editBanner->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Banner has updated successfully'
                ]); 
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put banner_translation_of as this number because  this number not belongs to any id default banner'
                ]); 
            }
        }else{
            $routeStoreDefaultMainbanner=route('/admin/categories/store_any_main_banner');
            return response()->json([
                'status'=>403,
                'message'=>'You cannt put banner_translation_of as this number , because until now not exist any banner for default language , so you can add a banner for default language from here  '.$routeStoreDefaultMainbanner.'after that you can return into here to add your banner for default banner'
            ]);  
        }         
    }else{
        return response()->json([
            'status'=>403,
            'message'=>'You cannt put banner_translation_of is 0 because this banner not for default language'
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
