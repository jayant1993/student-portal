<?php

namespace Payment\Helpers;

class PaytmHelper
{

    public static function generateFileName($file){

        $ext = $file->getClientOriginalExtension();

        $filename = str_random(15) . '.' . $ext;

        return $filename;
    }

    public static function uploadFile($file){

        $filename = (new self)->generateFileName($file);

        $move_file = (new self)->moveFile($file, $filename);

        return ["file" => [
            "filename" => $filename,
            "path" => base_path('storage/temp/' . $filename)
        ]];

    }

    public static function moveFile($file, $filename){

        try{

        $move = move_uploaded_file($file, base_path('storage/temp/' . $filename));

        if($move){
            return true;
        } else{
            return false;
        }

        } catch(Exception $e){
            return false;
        }

    }


    
}