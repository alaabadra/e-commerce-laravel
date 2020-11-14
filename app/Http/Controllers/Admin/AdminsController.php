<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use DB;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $admins=Admin::paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$admins
            ]);  
        }catch(\Exception $ex){
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);  
        }
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeAdminForDefaultLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLangDefaultInTableLang= forDefaultLang();
            if($resultLangDefaultInTableLang!==0){
               //upload image
                $filePath="";
                if($request->has('image')){
                    $filePath=uploadImage('admins',$request->image);
                }
                $countNameAdmin= Admin::where(['name'=>$data['name'],'language_id'=>$resultLangDefaultInTableLang->id,'admin_translation_of'=>null])->count();
                if($countNameAdmin!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt add this admin , because is exist same this admin for same this default language'
                    ]);
                }else{
                    Admin::insert(['image'=>$filePath,'language_id'=>$resultLangDefaultInTableLang->id,'admin_translation_of'=>null,'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'admin_status'=>$data['admin_status']]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'added new admin succefully'
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

    public function storeAdminForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['admin_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                $defaultAdminCount= Admin::where(['admin_translation_of'=>null])->count();
                if($defaultAdminCount!==0){//if exist an admin for the default language 
                    $defaultAdmin= Admin::where(['admin_translation_of'=>null])->get();
                    $arrDefaultAdmins=[];
                    foreach($defaultAdmin as $defaultAdmin){
                        array_push($arrDefaultAdmins, $defaultAdmin->id);
                    }
                    $isContain=  in_array($data['admin_translation_of'],$arrDefaultAdmins);
                    if($data['admin_translation_of']!==0){
                        if($isContain){       
                          // upload image
                            $filePath="";
                            if($request->has('image')){
                                $filePath=uploadImage('admins',$request->image);
                            }     
                            $countNameAdmin= Admin::where(['name'=>$data['name'],'language_id'=>$data['language_id'],'admin_translation_of'=>$data['admin_translation_of']])->count();
                            if($countNameAdmin!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this admin , because is exist same this admin for same this  language'
                                ]);
                            }else{
                                Admin::insert(['image'=>$filePath,'language_id'=>$data['language_id'],'admin_translation_of'=>$data['admin_translation_of'],'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'admin_status'=>$data['admin_status']]);
                                DB::commit();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new Admin succefully'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put admin_translation_of as this number because  this number not belongs to any id defaul admin'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put admin_translation_of is null because this admin not for default language'
                        ]); 
                    }
                }else{
                    $routeStoreDefaultAdmin=route('admin.admin.store_admin_for_default_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put admin_translation_of as this number , because until now not exist an admin for default language , so you can add  admin for default language from here: '.$routeStoreDefaultAdmin.' ,after that you can return into here to add you admin for defaul admin'
                    ]);  
                }         
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put admin_translation_of is null because thi admin not for default language'
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
            $admin=Admin::find($id);
            DB::commit();
            $admin=Admin::find($id);
            if($admin){
            return response()->json([
                'status'=>200,
                'message'=>$admin
            ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'This admin id not exist'
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateAdminForDefaultLang(Request $request, $id)
    {
        try{
            $admin=Admin::find($id);
            if(!$admin){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Admin id not exist'
                ]);
            }else{
                $data=$request->all();
                $resultLangDefaultInTableLang= forDefaultLang();
                if($resultLangDefaultInTableLang!==0){
                    DB::beginTransaction();
                    $countNameAdmin= Admin::where(['name'=>$data['name'],'language_id'=>$resultLangDefaultInTableLang->id,'admin_translation_of'=>null])->count();
                    if($countNameAdmin!==0){
                        return response()->json([
                            'status'=>200,
                            'message'=>'You cannt add this admin , because is exist same this admin for same this  language'
                        ]);
                    }else{
                       //upload image
                        $filePath="";
                        if($request->has('image')){
                            $filePath=uploadImage('admins',$request->image);
                        }
                        Admin::where(['id'=>$id])->update(['image'=>$filePath,'language_id'=>$resultLangDefaultInTableLang->id,'admin_translation_of'=>null,'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'admin_status'=>$data['admin_status']]);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'updated'.$admin->name.'succefully'
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

    public function updateAdminForAnyLang(Request $request, $id)
    {
        try{
            $admin=Admin::find($id);
            if(!$admin){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Admin id not exist'
                ]);
            }else{
                $data=$request->all();
                $resultLanguage= forAnyLang($data['admin_translation_of'],$data['language_id']);
                if($resultLanguage==true){
                    $defaultAdminCount= Admin::where(['admin_translation_of'=>null])->count();
                    if($defaultAdminCount!==0){//if exist an admin for the default language 
                        $defaultAdmin= Admin::where(['admin_translation_of'=>null])->get();
                        $arrDefaultAdmins=[];
                        foreach($defaultAdmin as $defaultAdmin){
                            array_push($arrDefaultAdmins, $defaultAdmin->id);
                        }
                        if($data['admin_translation_of']!==0){
                            $isContain=  in_array($data['admin_translation_of'],$arrDefaultAdmins);
                            if($isContain){
                                DB::beginTransaction();
                                $countNameAdmin= Admin::where(['name'=>$data['name'],'language_id'=>$data['language_id'],'admin_translation_of'=>$data['admin_translation_of']])->count();
                                if($countNameAdmin!==0){
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'You cannt add this admin , because is exist same this admin for same this  language'
                                    ]);
                                }else{
                                    //upload image
                                    $filePath="";
                                    if($request->has('image')){
                                        $filePath=uploadImage('admins',$request->image);
                                    }
                                    Admin::where(['id'=>$id])->update(['image'=>$filePath,'language_id'=>$data['language_id'],'admin_translation_of'=>null,'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'admin_status'=>$data['admin_status']]);
                                    DB::commit();
                                    return response()->json([
                                        'status'=>200,
                                        'message'=>'updated'.$admin->name.'succefully'
                                    ]);
                                }
                            }else{
                                return response()->json([
                                    'status'=>403,
                                    'message'=>'You cannt put admin_translation_of as this number because  this number not belongs to any id defaul admin'
                                ]); 
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put admin_translation_of is null because this admin not for default language'
                            ]); 
                        } 
                    }else{
                        $routeStoreDefaultAdmin=route('admin.admin.store_admin_for_default_lang');
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put admin_translation_of as this number , because until now not exist an admin for default language , so you can add  admin for default language from here: '.$routeStoreDefaultAdmin.' ,after that you can return into here to update you admin for defaul admin'
                        ]);  
                    }         
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put admin_translation_of is null because thi admin not for default language'
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
            $admin=Admin::find($id);
            if(!$admin){
                return response()->json([
                    'status'=>404,
                    'message'=>'This admin id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $admin->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this admin succefully'
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
