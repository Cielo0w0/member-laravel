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
