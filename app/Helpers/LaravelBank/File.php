<?php

namespace App\Helpers\LaravelBank;

use Illuminate\Support\Facades\Storage;

    class File{
        public static function _StoreImage($request){
            if($request->foto_profile){
                $fileName = $request->nik.'_profile';
                $fileExtension = $request->foto_profile->getClientOriginalExtension();
                $fileNameToStorage = $fileName.'_'.time().'.'.$fileExtension;
                $filePath = $request->foto_profile->storeAs('public/users' , $fileNameToStorage); 
            } 
            else {
                $fileNameToStorage = 'NULL';
            }
            return $fileNameToStorage;
        }

        public static function _DeleteImage($fileName){
            Storage::delete(['public/users/'.$fileName]);
        }
    }

?>