<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function index()
    {
        return view('/admin/contactus/index');
    }

    public function seemore()
    {
        return view('/admin/contactus/seemore');
    }
}

