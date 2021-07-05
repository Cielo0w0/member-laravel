<?php

namespace App\Http\Controllers;

use App\News;
use App\Product;
use App\ProductType;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //

    public function contactUs()
    {
        return view('/front/contact_us/index');
    }


    public function newsSummernote()
    {
        $news = News::get();
        return view('/front/news/index',compact('news'));
    }

    // get也可以留參數!
    public function product(Request $request)
    // public function product()
    {
        $types = ProductType::get();

        if ($request->type_id) {
            $products =Product::where('product_type_id',$request->type_id)->get();
        }else{
            $products = Product::get();
        }

        return view('/front/product/index', compact('products', 'types'));
    }
}
