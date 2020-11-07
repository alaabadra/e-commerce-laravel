<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $favorites=Favorite::with(['user','product'])->paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$favorites
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
        $productAttrs=ProductAttribute::favorites()->get();
        $users=User::favorites()->get();
        return response()->json([
            'status'=>200,
            'dataProductAttrs'=>$productAttrs,
            'dataUsers'=>$users,
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
            Favorite::insert(['user_id'=>$data['user_id'],'product_id'=>$data['product_id']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new Favorite succefully'
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
            $favorite=Favorite::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$favorite
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
            $favorite=Favorite::find($id);
            if(!$favorite){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Favorite id not exist'
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
            $favorite=Favorite::find($id);
            if(!$favorite){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Favorite id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Favorite::where(['id'=>$id])->update(['name'=>$data['name'],'abbr'=>$data['abbr'],'active'=>$data['active']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$favorite->name.'succefully'
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
            $favorite=Favorite::find($id);
            if(!$favorite){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Favorite id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $favorite->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this Favorite succefully'
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
