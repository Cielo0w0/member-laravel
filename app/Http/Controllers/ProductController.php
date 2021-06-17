<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    function __construct()
    {
        $this->index ='admin.product.item.index';
        $this->create ='admin.product.item.create';
        $this->edit ='admin.product.item.edit';
        $this->show ='admin.product.item.show';

    }

    public function index(){
        $lists = Product::get();

        return view($this->index,compact('lists'));
    }


    public function create(){

        $type=ProductType::get();

        return view($this->create,compact('type'));
    }

    public function store(Request $request){

        Product::create($request->all());

        return redirect('/admin/product/item')->with('message','新增產品成功!');
    }

    public function edit($id){
        $record =Product::find($id);
        $type=ProductType::get();

        return view($this->edit,compact('record','type'));
    }

    public function update(Request $request,$id){

        $old_record=Product::find($id);
        $old_record->product_name=$request->product_name;
        $old_record->price=$request->price;
        $old_record->discript=$request->discript;
        $old_record->product_type_id=$request->product_type_id;
        $old_record->save();

        return redirect('/admin/product/item')->with('message','編輯產品成功!');
    }

    public function delete(Request $request,$id){

        $old_record = Product::find($id);
        $old_record->delete();
        return redirect('/admin/product/item')->with('message','刪除產品成功!');
    }
}
