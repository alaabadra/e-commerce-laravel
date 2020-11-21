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

    public function storeBanner(Request $req)
    {
        try{
            $data=$req->all();
            DB::beginTransaction();
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

                $data=$req->all();
                DB::commit();
                $editBanner->banner_status=$data['banner_status'];
                $editBanner->banner_description=$data['banner_description'];
                $editBanner->banner_image=$data['banner_image'];
                $editBanner->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Banner has updated successfully'
                ]);   

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
        if(!empty($banner)){
            $banner->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Banner has deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
            ]);
        }

    }
    public function showBanner($id){
    $banner= Banner::where(['id'=>$id])->first();
    if(!empty($banner)){
        return response()->json([
            'status'=>200,
            'message'=>$banner
        ]);
    }else{
        return response()->json([
            'status'=>404,
            'message'=>'there is no data'
        ]);
    }
    
    }
}
