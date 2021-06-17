<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserClient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    function __construct()
    {
        $this->index ='admin.user.index';
        $this->create ='admin.user.create';
        $this->edit ='admin.user.edit';
        $this->show ='admin.user.show';

    }


    public function index(){

        $lists = User::get();
        return view($this->index,compact('lists'));
    }


    public function create(){
        return view($this->create);
    }

    public function store(Request $request){
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($v->fails()) {
            // 若其中一個錯
            return redirect()->back()->withErrors($v->errors());
        }

        $new_record=User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            // 'password' => $request['password'],
            'password' => Hash::make($request['password']),
            'role' =>$request['role'], //註冊時，預設會員的身分為一般使用者
        ]);

        if ($request->role==='user') {
            UserClient::create([
                'phone' => $request['phone'],
                'address' => $request['address'],
                'user_id'=>$new_record->id,
            ]);
        }

        return redirect('/admin/user')->with('message','新增會員成功!');
    }

    public function edit($id){
        $record = User::find($id);
        return view('admin.user.edit',compact('record'));
    }

    public function update(Request $request,$id){
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($v->fails()) {
            // 若其中一個錯
            return redirect()->back()->withErrors($v->errors());
        }

        $old_record = User::find($id);
        $old_record->name =$request->name;
        $old_record->password =Hash::make($request->password);
        // $old_record->role =$request->role;
        $old_record->save();

        if ($old_record->role==='user') {
            $old_client_record=UserClient::where('user_id',$old_record->id)->first();
            $old_client_record->phone=$request->phone;
            $old_client_record->address=$request->address;
            $old_client_record->save();
        }
        return redirect('/admin/user')->with('message','更新會員資料成功!');
    }


    public function delete(Request $request,$id){

        $old_record = User::find($id);
        if ($old_record->client) {
            $old_record->client->delete();
        }

        $old_record->client->delete();
        return redirect('/admin/user')->with('message','刪除會員資料成功!');
    }
}


