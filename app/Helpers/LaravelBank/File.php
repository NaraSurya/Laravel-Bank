<?php

namespace App\Helpers\LaravelBank;

use Illuminate\Support\Facades\Storage;

    class File{
        public static function _StoreImage($request , $folderName){
            if($request->foto_profile){
                $fileName = $request->nik.'_image';
                $fileExtension = $request->foto_profile->getClientOriginalExtension();
                $fileNameToStorage = $fileName.'_'.time().'.'.$fileExtension;
                $filePath = $request->foto_profile->storeAs('public/'.$folderName , $fileNameToStorage); 
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