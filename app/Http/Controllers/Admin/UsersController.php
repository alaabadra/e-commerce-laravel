<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
class UsersController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $users=User::paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$users
            ]);  
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
    public function create()
    {
        return view('carts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         try{
            $data=$request->all();
            DB::beginTransaction();
            //upload image
             $filePath="";
             if($request->has('image')){
                 $filePath=uploadImage('users',$request->image);
             }
            User::insert(['language_id'=>$data['language_id'],'user_translation_of'=>$data['user_translation_of'],'user_type'=>$data['user_type'],'image'=>$filePath,'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new User succefully'
            ]);
         }catch(\Exception $ex){
             DB::rollback();
             return response()->json([
                 'status'=>500,
                 'message'=>'There is something wrong, please try again'
             ]);
         }
    }



    public function storeUserForDefaultLang(Request $request)
    {
     try{
        $data=$request->all();
        DB::beginTransaction();
         $resultLangDefaultInTableLang= forDefaultLang();
         if($resultLangDefaultInTableLang!==0){    
            //upload image
            $filePath="";
            if($request->has('image')){
                $filePath=uploadImage('Users',$request->image);
            }
        
            $countNameUser= User::where(['name'=>$data['name'],'language_id'=>$resultLangDefaultInTableLang->id,'user_translation_of'=>null])->count();
            if($countNameUser!==0){
                return response()->json([
                    'status'=>200,
                    'message'=>'You cannt add this Product , because is exist same this Product for same this default language'
                ]);
            }else{
                User::insert(['image'=>$data['image'],'language_id'=>$resultLangDefaultInTableLang->id,'user_translation_of'=>null,'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'added new User succefully'
                ]);
            }
        }else{
            $routeViewDashboard=route('user.dashboard.generate_default_lang');
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

    public function storeUserForAnyLang(Request $request)
    {
        try{
            $data=$request->all();
            DB::beginTransaction();
            $resultLanguage= forAnyLang($data['user_translation_of'],$data['language_id']);
            if($resultLanguage==true){
                $defaultUserCount= User::where(['user_translation_of'=>null])->count();
                if($defaultUserCount!==0){//if exist any user for the default language 
                    $defaultUsers= User::where(['user_translation_of'=>null])->get();
                    $arrDefaultUsers=[];
                    foreach($defaultUsers as $defaultUser){
                        array_push($arrDefaultUsers, $defaultUser->id);
                    }
                    $isContain=  in_array($data['user_translation_of'],$arrDefaultUsers);
                    if($data['user_translation_of']!==0){
                        if($isContain){       
                            //upload image
                            $filePath="";
                            if($request->has('image')){
                                $filePath=uploadImage('users',$request->image);
                            }     
                            $countNameUser= User::where(['name'=>$data['name'],'language_id'=>$data['language_id'],'user_translation_of'=>$data['user_translation_of']])->count();
                            if($countNameUser!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this product , because is exist same this product for same this  language'
                                ]);
                            }else{
                                User::insert(['image'=>$data['image'],'language_id'=>$data['language_id'],'user_translation_of'=>$data['user_translation_of'],'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
                                DB::commit();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'added new User succefully'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put user_translation_of as this number because  this number not belongs to any id default user'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put user_translation_of is null because this product not for default language'
                        ]); 
                    }
                }else{
                    $routeStoreDefaultUser=route('admin.user.store_user_for_default_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put user_translation_of as this number , because until now not exist any user for default language , so you can add a user for default language from here:'.$routeStoreDefaultUser.'after that you can return into here to add your user for default user'
                    ]);  
                }         
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put user_translation_of is null because this user not for default language'
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
            $user=User::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$user
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
    
    public function updateUserForDefaultLang(Request $request, $id)
    {
        try{
            $user=User::find($id);
            if(!$user){
                return response()->json([
                    'status'=>404,
                    'message'=>'This User id not exist'
                ]);
            }else{
                $data=$request->all();
                $resultLangDefaultInTableLang= forDefaultLang();
                if($resultLangDefaultInTableLang!==0){
                DB::beginTransaction();
                $countNameUser= User::where(['name'=>$data['name'],'language_id'=>$data['language_id'],['id','!=',$id],'user_translation_of'=>$data['user_translation_of']])->count();
                if($countNameUser!==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'You cannt add this admin , because is exist same this admin for same this  language'
                    ]);
                }else{
                    //upload image
                    $filePath="";
                    if($request->has('image')){
                        $filePath=uploadImage('users',$request->image);
                    }
                    User::where(['id'=>$id])->update(['image'=>$filePath,'language_id'=>$resultLangDefaultInTableLang->id,'user_translation_of'=>null,'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'updated'.$user->name.'succefully'
                    ]);
                }
            }else{
                $routeViewDashboard=route('user.dashboard.generate_default_lang');
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

    public function updateUserForAnyLang(Request $request, $id)
    {
         try{
            $user=User::find($id);
            if(!$user){
                return response()->json([
                    'status'=>404,
                    'message'=>'This User id not exist'
                ]);
            }else{
                $data=$request->all();
                 $resultLanguage= forAnyLang($data['user_translation_of'],$data['language_id']);
                 if($resultLanguage==true){
                $defaultUserCount= User::where(['user_translation_of'=>0])->count();
                if($defaultUserCount!==0){//if exist any user for the default language 
                    $defaultUsers= User::where(['user_translation_of'=>0])->get();
                    $arrDefaultUsers=[];
                    foreach($defaultUsers as $defaultUser){
                        array_push($arrDefaultUsers, $defaultUser->id);
                    }
                    if($data['user_translation_of']!==0){
                        $isContain=  in_array($data['user_translation_of'],$arrDefaultUsers);
                        if($isContain){
                            DB::beginTransaction();
                            $countNameUser= User::where(['name'=>$data['name'],'language_id'=>$data['language_id'],['id','!=',$id],'user_translation_of'=>$data['user_translation_of']])->count();
                            if($countNameUser!==0){
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'You cannt add this admin , because is exist same this admin for same this  language'
                                ]);
                            }else{
                                //upload image
                                $filePath="";
                                if($request->has('image')){
                                    $filePath=uploadImage('users',$request->image);
                                }
                                User::where(['id'=>$id])->update(['image'=>$filePath,'language_id'=>$data['language_id'],'user_translation_of'=>null,'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
                                DB::commit();
                                return response()->json([
                                    'status'=>200,
                                    'message'=>'updated'.$user->name.'succefully'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'status'=>403,
                                'message'=>'You cannt put user_translation_of as this number because  this number not belongs to any id default user'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'status'=>403,
                            'message'=>'You cannt put user_translation_of is null because this product not for default language'
                        ]); 
                    } 
                }else{
                    $routeStoreDefaultUser=route('admin.user.store_user_for_default_lang');
                    return response()->json([
                        'status'=>403,
                        'message'=>'You cannt put user_translation_of as this number , because until now not exist any user for default language , so you can add a user for default language from here:'.$routeStoreDefaultUser.',after that you can return into here to add your user for default user'
                    ]);  
                }         
            }else{
                return response()->json([
                    'status'=>403,
                    'message'=>'You cannt put user_translation_of is null because this user not for default language'
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
            $user=User::find($id);
            if(!$user){
                return response()->json([
                    'status'=>404,
                    'message'=>'This User id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $user->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this User succefully'
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
