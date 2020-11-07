<?php

function uploadImage($folder,$image){
    $image->store('/',$folder);
    $filename=$image->hasName();
    $path='images/'.$folder.'/'.$filename;
    return $path;
  }

function forDefaultLang(){
  $localLang= Config::get('app.locale');
    $langDefaultInTableLangCount=Language::where(['language_abbr'=>$localLang])->count();
    if($langDefaultInTableLangCount!==0){//the default lang is exist in table language
        $langDefaultInTableLang=Language::where(['language_abbr'=>$localLang])->first();//get default language from table languages
        return $langDefaultInTableLang;
    }else{
      $routeViewDashboard='admin/dashboard/view';
      return response()->json([
          'status'=>500,
          'message'=>'There is something wrong, please try again, because this website not contain on the default language , pls click here to generate it'.$routeViewDashboard.'after that you can return into this route'
      ]);

  }
}

function forAnyLang($dataTranslation){
  $languageIdCount=Language::where(['id'=>$dataTranslation])->count();
  if($languageIdCount!==0){//if id language taht from request : isexit in table language or not                 
      if($dataTranslation!==0){
        return true;
      }else{
        return false;
         
    }
    }else{
return response()->json([
    'status'=>403,
    'message'=>'You cannt put this id for language , because this id not exist'
]);     
}
  


}