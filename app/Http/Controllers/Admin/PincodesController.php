<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Pincode;
use Illuminate\Http\Request;
use DB;

class PincodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $pincodes=Pincode::with(['delivery'])->paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$pincodes
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
        try{
            $data=$request->all();
            DB::beginTransaction();
            Pincode::insert(['pincode'=>$data['pincode'],'delivery_id'=>$data['delivery_id'],'pincode_status'=>$data['pincode_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new Pincode succefully'
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
            $pincode=Pincode::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$pincode
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
    public function update(Request $request, $id)
    {
        try{
            $pincode=Pincode::find($id);
            if(!$pincode){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Pincode id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Pincode::where(['id'=>$id])->update(['pincode'=>$data['pincode'],'delivery_id'=>$data['delivery_id'],'pincode_status'=>$data['pincode_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$pincode->name.'succefully'
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
        try{
            $pincode=Pincode::find($id);
            if(!$pincode){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Pincode id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $pincode->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this Pincode succefully'
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
