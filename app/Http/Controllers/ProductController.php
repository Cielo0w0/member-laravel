<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductImg;
use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

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
        $new_record = Product::create($request->all());

        if ($request->hasFile('photos')) {
            foreach ($request -> file('photos') as $item) {
                $path = FileController::imageUpload($item);

                ProductImg::create([
                    'photo'=>$path,
                    'product_id'=>$new_record->id,
                ]);
            }
        }

        // Product::create($request->all());

        return redirect('/admin/product/item')->with('message','新增產品成功!');
    }




    public function edit($id){
        $record =Product::find($id);
        $type=ProductType::get();
        $photos = $record->photos;

        return view($this->edit,compact('record','type','photos'));
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


    public function deleteImage(Request $request){
        // 透過ID找要刪除的資料
        $old_record = ProductImg::find($request->id);
        // 判斷該資料是否還存在
        if (file_exists(public_path().$old_record->photo)) {
            // 存在的話就執行刪除動作
            File::delete(public_path().$old_record->photo);
        }
        $old_record->delete();
    }
}
