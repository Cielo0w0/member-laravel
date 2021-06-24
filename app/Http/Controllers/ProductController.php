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
        $this->index = 'admin.product.item.index';
        $this->create = 'admin.product.item.create';
        $this->edit = 'admin.product.item.edit';
        $this->show = 'admin.product.item.show';
    }




    public function index()
    {
        $lists = Product::get();

        return view($this->index, compact('lists'));
    }




    public function create()
    {

        $type = ProductType::get();

        return view($this->create, compact('type'));
    }




    public function store(Request $request)
    {
        //單圖片
        $requestData = $request->all();
        if ($request->hasFile('photo')) {
            $requestData['photo'] = FileController::imageUpload($request->file('photo'), 'product');
        }
        $new_record = Product::create($requestData);

        // 多圖片
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $item) {
                $path = FileController::imageUpload($item, 'product');

                ProductImg::create([
                    'photo' => $path,
                    'product_id' => $new_record->id,
                ]);
            }
        }

        // Product::create($request->all());

        return redirect('/admin/product/item')->with('message', '新增產品成功!');
    }




    public function edit($id)
    {
        $record = Product::with('photos')->find($id); //這有with
        $type = ProductType::get();
        // $photos = $record->photos;                //就不用這些了
        // return view($this->edit,compact('record','type','photos'));
        return view($this->edit, compact('record', 'type'));
    }





    public function update(Request $request, $id)
    {

        $record = Product::with('photos')->find($id);
        $requestData = $request->all();

        // 單圖片
        if ($request->hasFile('photo')) {
            File::delete(public_path() . $record->photo);
            $path = FileController::imageUpload($request->file('photo'), 'product');
            $requestData['photo'] = $path;
        }
        $record->update($requestData);


        // 多圖片
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = FileController::imageUpload($file, 'product');

                ProductImg::create([
                    'product_id' => $record->id,
                    'photo' => $path,
                ]);
            }
        }
        // $old_record=Product::with('photos')->find($id);

        // $old_record->product_name=$request->product_name;
        // $old_record->price=$request->price;
        // $old_record->discript=$request->discript;
        // $old_record->product_type_id=$request->product_type_id;
        // $old_record->save();

        return redirect('/admin/product/item')->with('message', '編輯產品成功!');
    }




// 這個是整筆刪除的時候，要把圖片檔案從資料庫刪除
    public function delete(Request $request, $id)
    {
        $record = Product::with('photos')->find($id);
        // 刪除主要照片
        File::delete(public_path().$record->photo);
        // 刪除其他照片
        foreach($record->photos as $photo){
            // 刪除其他圖片的檔案
            File::delete(public_path().$photo->photo);
            // 刪除其他圖片的資料
            $photo->delete();
        }
        $record->delete();
        return redirect('/admin/product/item')->with('message', '刪除產品成功!');
    }

// 這個是 編輯時按叉叉 刪掉單一張照片
    public function deleteImage(Request $request)
    {
        // 透過ID找要刪除的資料
        $old_record = ProductImg::find($request->id);
        // 判斷該資料是否還存在
        if (file_exists(public_path() . $old_record->photo)) {
            // 存在的話就執行刪除動作
            File::delete(public_path() . $old_record->photo);
        }
        $old_record->delete();

        return 'success';
    }
}
