<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
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
        if ( $request->img) {
            // 如果存圖片的資料夾不存在(沒有可上傳檔案的資料夾=dir)
            if (!is_dir('upload/')) {
                // 那就創立一個
                mkdir('upload/');
            }

            // 找到原始副檔名
            $extenstion =$request->img->getClientOriginalExtension();
            // 重新命名原始檔名，且命名不重複 & 有規則(這裡沒有，可以自己去找方法)
            // $filename=md5(uniqid(rand()));

            // 將兩者結合，就是我重新命名的檔案名稱
            $filename=md5(uniqid(rand())).'.'. $extenstion;

            // 最後把圖片從暫存->正式存下來
            // move_uploaded_file(要存的檔案,'path=檔案要存到哪個路徑');

            // 可以寫 :
            // $file = $request->img

            // 但laravel中較嚴謹的取得文件方式 : file('要取的東西name');
            $file = $request->file('img');
            move_uploaded_file($file,);


        }

        News::create([
            'type'=>$request->type,
            'publish_date'=>date("Y-m-d"),
            'title'=>$request->title,
            'img'=>'1',
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
