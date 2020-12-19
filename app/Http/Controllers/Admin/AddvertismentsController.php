<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Addvertisment;
use Illuminate\Http\Request;
use DB;

class AddvertismentsController extends Controller
{
    public function view(){
        try{
        $addvertisments=Addvertisment::get();
        if(!empty($addvertisments)){
            return response()->json([
                'status'=>200,
                'message'=>$addvertisments
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
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

    public function store(Request $req)
    {
        //try{
            $data=$req->all();
            DB::beginTransaction();
            $newaddvertisment= new  Addvertisment();
            $newaddvertisment->addvertisment_status=$data['addvertisment_status'];
            $newaddvertisment->addvertisment_description=$data['addvertisment_description'];
            $newaddvertisment->addvertisment_image=$data['addvertisment_image'];
            $newaddvertisment->addvertisment_link=$data['addvertisment_link'];
            $newaddvertisment->save();
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'addvertisment has added successfully'
            ]);
                    
        //  }catch(\Exception $ex){
        //      DB::rollback();
        //      return response()->json([
        //          'status'=>500,
        //          'message'=>'There is something wrong, please try again'
        //      ]);
        //  }
}


    public function update(Request $req,$id=null){
        try{
           $editaddvertisment=Addvertisment::where(['id'=>$id])->first();
           if($editaddvertisment){

                   $data=$req->all();
                   $countNameaddvertisment= Addvertisment::where(['addvertisment_description'=>$data['addvertisment_description'],['id','!=',$id],'language_id'=>$data['language_id'],'addvertisment_translation_of'=>$data['addvertisment_translation_of']])->count();
                   if($countNameaddvertisment!==0){
                       return response()->json([
                           'status'=>200,
                           'message'=>'You cannt put this addvertisment , because is exist same this addvertisment for same this  language'
                        ]);
                    }else{
                        DB::beginTransaction();
                        $editaddvertisment->addvertisment_status=$data['addvertisment_status'];
                        $editaddvertisment->addvertisment_description=$data['addvertisment_description'];

                        //upload image
                        $filePath="";
                        if($req->has('image')){
                            $filePath=uploadImage('addvertisments',$req->photo);
                            $editaddvertisment->addvertisment_image=$filePath;
                        }
                        $editaddvertisment->save();
                        DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'addvertisment has updated successfully'
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


    public function delete($id=null){
        try{
        $addvertisment=Addvertisment::where(['id'=>$id])->first();
        if(!empty($addvertisment)){
            DB::beginTransaction();
            $addvertisment->delete();
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'addvertisment has deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
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
public function show($id){
    try{
   $addvertisment= Addvertisment::where(['id'=>$id])->first();
   if(!empty($addvertisment)){
       return response()->json([
        'status'=>200,
        'message'=>$addvertisment
       ]);
   }else{
        return response()->json([
            'status'=>404,
            'message'=>'there is no data'
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
