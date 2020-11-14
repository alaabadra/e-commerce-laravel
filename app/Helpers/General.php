<?php
use App\Models\Language;
function uploadImage($folder,$image){
  // dd($image);
    $image->store('/',$folder);
    $filename=$image->hasName();
    $path='images/'.$folder.'/'.$filename;
    return $path;
  }

function forDefaultLang(){
  // dd(00);
  $localLang= Config::get('app.locale');
  // dd($localLang);
    $langDefaultInTableLangCount=Language::where(['language_abbr'=>$localLang])->count();
    if($langDefaultInTableLangCount!==0){//the default lang is exist in table language
        $langDefaultInTableLang=Language::where(['language_abbr'=>$localLang])->first();//get default language from table languages
        return $langDefaultInTableLang;
    }else{
      return  null;     
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