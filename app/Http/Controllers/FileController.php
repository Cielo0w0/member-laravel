<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{

    public static function imageUpload($file){

        if (!is_dir('upload/')) {
            mkdir('upload/');
        }

        $extenstion =$file->getClientOriginalExtension();

        $filename = md5(uniqid(rand())).'.'. $extenstion;
        $path='/upload/'.$filename;
        move_uploaded_file($file , public_path().$path);

        return $path;
    }

}
