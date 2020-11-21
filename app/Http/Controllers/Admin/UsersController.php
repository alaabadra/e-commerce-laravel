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
      //$r=  auth('admin')->user();
      //dd($r);

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
    public function getAllUsers(){
        try{
        $allUsers=User::get();
        return response()->json([
            'status'=>200,
            'message'=>$allUsers
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
    public function store(Request $request)
    {
        //  try{
            $data=$request->all();
            //upload image
            // $filePath="";
            // if($request->has('image')){
            //     $filePath=uploadImage('users',$request->image);
            // }
            DB::beginTransaction();
            $emailExistCount=User::where(['email'=>$data['email']])->count();
            if($emailExistCount==0){
            User::insert(['image'=>$data['image'], 'name'=>$data['name'],'user_status'=>$data['user_status'],'num_card'=>$data['num_card'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'phone'=>$data['phone'],'address'=>$data['address']]);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'added new User succefully'
                        ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'you cannt add this user , because this user email is exist'
                ]);
            }
            
        //  }catch(\Exception $ex){
        //      DB::rollback();
        //      return response()->json([
        //          'status'=>500,
        //          'message'=>'There is something wrong, please try again'
        //      ]);
        //  }
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
            if(!empty($user)){
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>$user
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $id)
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
                     DB::beginTransaction();
                    User::where(['id'=>$id])->update(['image'=>$data['image'],'name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'updated'.$user->name.'succefully'
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // try{
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
            
        // }catch(\Exception $ex){
        //     DB::rollback();
        //     return response()->json([
        //         'status'=>500,
        //         'message'=>'There is something wrong, please try again'
        //     ]);
        // }
    }
}
