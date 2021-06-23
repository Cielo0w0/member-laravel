<?php

namespace App\Http\Controllers;

use App\ProductImg;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public static function imageUpload($file,$dir){
        // 如果上傳檔案的資料夾不存在
        if (!is_dir('upload/')) {
            // 那就創一個可以上傳的資料夾
            mkdir('upload/');
        }

        if (!is_dir('upload/'.$dir.'/')) {
            mkdir('upload/'.$dir.'/');
        }

        $extenstion =$file->getClientOriginalExtension();

        $filename = md5(uniqid(rand())).'.'. $extenstion;
        $path='/upload/'.$dir.'/'.$filename;
        move_uploaded_file($file , public_path().$path);

        return $path;
    }

}
