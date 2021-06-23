<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{

    function __construct()
    {
        $this->index ='admin.product.type.index';
        $this->create ='admin.product.type.create';
        $this->edit ='admin.product.type.edit';
        $this->show ='admin.product.type.show';

    }

    public function index(){

        $lists = ProductType::get();

        return view($this->index, compact('lists'));
    }

    public function create(){
        return view($this->create);
    }

    public function store(Request $request){

        ProductType::create([
            'type_name' => $request -> type_name
        ]);

        return redirect('/admin/product/type')->with('message','新增產品種類成功!');
    }

    public function edit($id){
        $record =ProductType::find($id);

        return view($this->edit,compact('record'));
    }

    public function update(Request $request,$id){
        $old_record =ProductType::find($id);
        $old_record->type_name=$request->type_name;
        $old_record->save();

        return redirect('/admin/product/type')->with('message','編輯產品種類成功!');
    }

    public function delete(Request $request,$id){
        $old_record =ProductType::find($id);

        if ( $old_record ->product->count()!=0) {
            return redirect('/admin/product/type')->with('message',
            '無法刪除該產品種類!該產品種類內還有'.$old_record->product->count().'筆產品品項，請先刪除');
        }elseif($old_record ->product->count()===0){
            $old_record->delete();
            return redirect('/admin/product/type')->with('message','刪除產品種類成功!');
        }

    }


}
