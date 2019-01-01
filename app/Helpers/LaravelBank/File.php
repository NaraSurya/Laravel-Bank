<?php

namespace App\Helpers\LaravelBank;

use Illuminate\Support\Facades\Storage;

    class File{
        public static function _StoreImage($request , $folderName){
            if($request->picture){
                $fileName = $request->name.'_image';
                $fileExtension = $request->picture->getClientOriginalExtension();
                $fileNameToStorage = $fileName.'_'.time().'.'.$fileExtension;
                $filePath = $request->picture->storeAs('public/'.$folderName , $fileNameToStorage); 
            } 
            else {
                $fileNameToStorage = 'null.jpg';
            }
            return $fileNameToStorage;
        }

        public static function _DeleteImage($fileName , $folderName){
            if($fileName != 'null.jpg'){
                Storage::delete(['public/'.$folderName.'/'.$fileName]);
            }
            
        }
    }

?>