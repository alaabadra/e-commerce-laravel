<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

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
            return response()->json([
                'status'=>200,
                'message'=>$deliveries
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
        $users=User::deliveries()->get();
        return response()->json([
            'status'=>200,
            'dataUsers'=>$users
        ]);
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
            Delivery::insert(['user_id'=>$data['user_id'],'delivery_status'=>$data['delivery_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new delivery succefully'
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
            $delivery=Delivery::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$delivery
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
            $delivery=Delivery::find($id);
            if(!$delivery){
                return response()->json([
                    'status'=>404,
                    'message'=>'This delivery id not exist'
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
            $delivery=Delivery::find($id);
            if(!$delivery){
                return response()->json([
                    'status'=>404,
                    'message'=>'This delivery id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Delivery::where(['id'=>$id])->update(['user_id'=>$data['user_id'],'delivery_status'=>$data['delivery_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$delivery->name.'succefully'
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
