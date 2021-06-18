<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class NewsController extends Controller
{
    //
    function __construct()
    {
        $this->index ='admin.news.index';
        $this->create ='admin.news.create';
        $this->edit ='admin.news.edit';
        $this->show ='admin.news.show';

    }




    public function index(){
        $lists = News::get();
        return view($this->index,compact('lists'));
    }



    public function create(){
        $type =News::TYPE;

        return view($this->create,compact('type'));
    }



    public function store(Request $request){
        // 如果IMG有檔案
        if ( $request->hasFile('img')) {
            $path = FileController::imageUpload($request->file('img'));
        }

        News::create([
            'type'=>$request->type,
            'publish_date'=>date("Y-m-d"),
            'title'=>$request->title,
            // 把圖片存的路徑寫入img : http://127.0.0.1:8000/upload/圖片檔案名稱.副檔名  (*上面註1)
            // ( 將圖片儲存的路徑存入資料庫 )
            'img'=>$path??'',
            'content'=>$request->content,

        ]);

        return redirect('/admin/news')->with('message','新增最新消息成功!');
    }





    public function edit($id){
        $record =News::find($id);
        $type=News::TYPE;

        return view($this->edit,compact('record','type'));
    }




    public function update(Request $request,$id){

        $old_record=News::find($id);

        if ( $request->hasFile('img')) {
            // 刪除舊照片
            File::delete(public_path(). $old_record->img);

            $file =$request->file('img');

            if (!is_dir('upload/')) {
                // 那就創立一個
                mkdir('upload/');
            }

            $extenstion =$request->img->getClientOriginalExtension();
            $filename = md5(uniqid(rand())).'.'. $extenstion;
            $path='/upload/'.$filename;
            move_uploaded_file($file , public_path().$path);

            $old_record->img=$path;
        }

        $old_record->type=$request->type;
        $old_record->title=$request->title;
        $old_record->content=$request->content;
        $old_record->save();

        return redirect('/admin/news')->with('message','編輯最新消息成功!');
    }




    public function delete(Request $request,$id){

        $old_record = News::find($id);
        $old_record->delete();
        return redirect('/admin/news')->with('message','刪除最新消息成功!');
    }


}
