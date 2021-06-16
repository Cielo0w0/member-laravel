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


    // public function create(){
    //     return view($this->index);
    // }

    // public function edit(){
    //     return view($this->index);
    // }
}
