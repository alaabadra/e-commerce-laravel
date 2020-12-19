<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use DB;
class DeliveriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $deliveries=Delivery::with(["user"])->paginate(10);
            if(!empty($deliveries)){
                return response()->json([
                    'status'=>200,
                    'message'=>$deliveries
                ]);  
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);
            }
        }catch(\Exception $ex){
            return response()->json([
                'status'=>500,
                'message'=>'There is something wrong, please try again'
            ]);  
        }
        
    }

    public function getAllDeliveries(){
        try{
        $allDeliveries=Delivery::get();
        return response()->json([
            'status'=>200,
            'message'=>$allDeliveries
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
            Delivery::insert(['order_code'=>$data['order_code'],'deliver_company'=>$data['deliver_company'],'delivery_status'=>$data['delivery_status'],'deliver_num'=>$data['deliver_num'],'deliver_destination'=>$data['deliver_destination'],'deliver_name'=>$data['deliver_name']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new delivery succefully'
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
            $delivery=Delivery::find($id);
            if(!empty($delivery)){
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>$delivery
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
        //try{
            $delivery=Delivery::find($id);
            if(!$delivery){
                return response()->json([
                    'status'=>404,
                    'message'=>'This delivery id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Delivery::where(['id'=>$id])->update(['order_code'=>$data['order_code'],'deliver_company'=>$data['deliver_company'],'delivery_status'=>$data['delivery_status'],'deliver_num'=>$data['deliver_num'],'deliver_destination'=>$data['deliver_destination'],'deliver_name'=>$data['deliver_name']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$delivery->name.'succefully'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try{
            $delivery=Delivery::find($id);
            if(!$delivery){
                return response()->json([
                    'status'=>404,
                    'message'=>'This delivery id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $delivery->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this delivery succefully'
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
