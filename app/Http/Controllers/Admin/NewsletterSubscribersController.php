<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\NewsLetterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscribersController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $newsLetters=NewsLetterSubscriber::paginate(10);
            return response()->json([
                'status'=>200,
                'message'=>$newsLetters
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
            NewsLetterSubscriber::insert(['email'=>$data['email'],'newsletter_subscriber_status'=>$data['newsletter_subscriber_status']]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added new NewsLetterSubscriber succefully'
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
            $newsLetter=NewsLetterSubscriber::find($id);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>$newsLetter
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
            $newsLetter=NewsLetterSubscriber::find($id);
            if(!$newsLetter){
                return response()->json([
                    'status'=>404,
                    'message'=>'This NewsLetterSubscriber id not exist'
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
            $newsLetter=NewsLetterSubscriber::find($id);
            if(!$newsLetter){
                return response()->json([
                    'status'=>404,
                    'message'=>'This NewsLetterSubscriber id not exist'
                ]);
            }else{
                $data=$request->all();
                DB::beginTransaction();
                NewsLetterSubscriber::where(['id'=>$id])->update(['email'=>$data['email'],'newsletter_subscriber_status'=>$data['newsletter_subscriber_status']]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated'.$newsLetter->name.'succefully'
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
            $newsLetter=NewsLetterSubscriber::find($id);
            if(!$newsLetter){
                return response()->json([
                    'status'=>404,
                    'message'=>'This NewsLetterSubscriber id not exist'
                ]);
            }else{
                DB::beginTransaction();
                $newsLetter->delete();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted this NewsLetterSubscriber succefully'
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
