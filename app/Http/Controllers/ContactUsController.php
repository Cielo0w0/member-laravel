<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function index()
    {
        $lists = ContactUs::get();
        return view('admin.contactus.index',compact('lists'));
    }



    public function store(Request $request)
    {

        ContactUs::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'subject' =>$request->subject,
            'message' =>$request->message,
        ]);
        return redirect('/contact_us')->with('message','聯絡我們成功!');
    }



    public function seemore($id)
    {
        $more = ContactUs::find($id);
        return view('/admin/contactus/seemore',compact('more'));
    }



    public function delete(Request $request,$id)
    {
        $old_record = ContactUs::find($id);
        $old_record->delete();
        return redirect('/admin/contactus')->with('message','刪除聯絡我們成功!');

    }

}

