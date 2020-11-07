<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
            User::insert(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $user=User::find($id);
            if(!$user){
                return response()->json([
                    'status'=>404,
                    'message'=>'This User id not exist'
                ]);
            }else{
                
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
                User::where(['id'=>$id])->update(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'user_status'=>$data['user_status']]);
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
    public function destroy($id)
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
