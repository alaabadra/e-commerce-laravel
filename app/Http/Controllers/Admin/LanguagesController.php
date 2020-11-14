<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $languages=Language::paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$languages
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
            Language::insert(['language_abbr'=>$data['language_abbr'],'language_name'=>$data['language_name'],'language_native'=>$data['language_native'],'language_flag'=>$data['language_flag'],'language_active'=>$data['language_active']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new language succefully'
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
            $language=Language::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$language
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
            $language=Language::find($id);
            if(!$language){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Language id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                Language::where(['id'=>$id])->update(['language_abbr'=>$data['language_abbr'],'language_name'=>$data['language_name'],'language_native'=>$data['language_native'],'language_flag'=>$data['language_flag'],'language_active'=>$data['language_active']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$language->name.'succefully'
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
            $language=Language::find($id);
            if(!$language){
                return response()->json([
                    'status'=>404,
                    'message'=>'This Language id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $language->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this Language succefully'
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
