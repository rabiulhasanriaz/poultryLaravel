<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function create(){
        return view('company.user.registration');
    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'u_name' => 'required',
            'u_phone' => 'required|unique:users,phone',
            'u_password' => 'required',
            
        ],[
            'u_name.required' => 'User Name is Required',
            'u_phone.required' => 'User Phone is Required',
            'u_phone.unique' => 'Phone is Exist',
            'u_password.required' => 'User Password is Required',
            
        ]);
         
        $com = Auth::user()->company_id;
        $data = new User();
        $data->company_id = $com;
        $data->name = $request->u_name;
        $data->phone = $request->u_phone;
        $data->email = $request->u_email;
        $data->password = md5($request->u_password);
        $data->rawp = $request->u_password;
        $data->address = $request->u_address;
        $data->user_type = 3;
        if ($request->hasfile('u_logo') != '') {
            $file = $request->file('u_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().random_int(10,99) . "." . $extension;
    
            $path = $request->u_logo->move('assets/user-image', $filename);
            $data->logo = $filename;
            
        }
        // $data->logo = $request->u_logo;

        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'User Created');
        return redirect()->back();

    }

    public function userList(){
        $com = Auth::user()->company_id;
        $users = User::where('company_id',$com)->where('user_type',3)->get();
        return view('company.user.list',compact('users'));
    }

    public function userUpdateAjax(Request $request){
        $user = User::where('id',$request->value)->first();
        return view('company.user.ajax.user-update',compact('user'));
    }

    public function userUpdate(Request $request,$id){
        $request->validate([
            'u_name' => 'required',
            'u_phone' => 'required',
            
        ],[
            'u_name.required' => 'User Name is Required',
            'u_phone.required' => 'User Phone is Required',
            
        ]);

        $com = Auth::user()->company_id;
        $data = User::where('company_id',$com)->where('id',$id)->first();
        $data->company_id = $com;
        $data->name = $request->u_name;
        $data->phone = $request->u_phone;
        $data->email = $request->u_email;
        if ($request->u_password != '') {
            $data->password = md5($request->u_password);
            $data->rawp = $request->u_password;
        }
        $data->address = $request->u_address;
        $data->user_type = 3;
        if ($request->hasfile('u_logo') != '') {
            $file = $request->file('u_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().random_int(10,99) . "." . $extension;
    
            $path = $request->u_logo->move('assets/user-image', $filename);
            $data->logo = $filename;
            
        }
        // $data->logo = $request->u_logo;

        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'User Updated');
        return redirect()->back();
    }
}
