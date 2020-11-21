<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Http\Request;
use DB;
class ContractorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
        $contractors=Contractor::get();
        return response()->json([
            'status'=>200,
            'message'=>$contractors
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
        // try{
            $data=$request->all();
            DB::beginTransaction();
            Contractor::insert(['contractor_name'=>$data['contractor_name'],'contractor_phone'=>$data['contractor_phone'],'contractor_address'=>$data['contractor_address'],'contractor_commission'=>$data['contractor_commission'],'start_date'=>$data['start_date'],'end_date'=>$data['end_date'],'contractor_status'=>$data['contractor_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new Contractor succefully'
            ]);
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
            $contractor=Contractor::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$contractor
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
            $contractor=Contractor::find($id);
            if(!$contractor){
                return response()->json([
                    'status'=>404,
                    'message'=>'This co$contractor id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Contractor::where(['id'=>$id])->update(['contractor_name'=>$data['contractor_name'],'contractor_phone'=>$data['contractor_phone'],'contractor_address'=>$data['contractor_address'],'contractor_commission'=>$data['contractor_commission']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$contractor->contractor_name.'succefully'
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
            $contractor=Contractor::find($id);
            if(!$contractor){
                return response()->json([
                    'status'=>404,
                    'message'=>'This co$contractor id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $contractor->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this co$contractor succefully'
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
