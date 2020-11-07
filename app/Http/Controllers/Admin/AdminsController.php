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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
            Admin::insert(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'admin_status'=>$data['admin_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'add new admin succefully'
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
            $admin=Admin::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$admin
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
            $admin=Admin::find($id);
            if(!$admin){
                return response()->json([
                    'status'=>404,
                    'message'=>'This admin id not exist'
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
            $admin=Admin::find($id);
            if(!$admin){
                return response()->json([
                    'status'=>404,
                    'message'=>'This admin id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Admin::where(['id'=>$id])->update(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'admin_status'=>$data['admin_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$admin->name.'succefully'
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
