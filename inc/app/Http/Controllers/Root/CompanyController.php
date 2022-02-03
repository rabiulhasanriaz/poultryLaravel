<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class CompanyController extends Controller
{
    public function create(){
        return view('root.company.create');
    }

    public function store(Request $request){
        // dd(md5($request->c_password));
        $request->validate([
            'c_name' => 'required',
            'c_phone' => 'required',
            'c_address' => 'required',
            'c_password' => 'required',
            
        ],[
            'c_name.required' => 'Company Name is Required',
            'c_phone.required' => 'Company Phone is Required',
            'c_address.required' => 'Company Address is Required',
            'c_password.required' => 'Company Password is Required',
            
        ]);
        $company_id = User::where('company_id', '!=' , '')->max('company_id');
        $newCom = $company_id + 1;
        
        
        $data = new User();
        $data->company_id = $newCom;
        $data->name = $request->c_name;
        $data->contact_person = $request->c_person;
        $data->phone = $request->c_phone;
        $data->email = $request->c_email;
        $data->password = md5($request->c_password);
        $data->rawp = $request->c_password;
        $data->address = $request->c_address;
        $data->user_type = 2; //Company Admin

        if ($request->hasfile('c_logo') != '') {
            $file = $request->file('c_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().random_int(10,99) . "." . $extension;
    
            $path = $request->c_logo->move('assets/image', $filename);
            $data->logo = $filename;
            
        }
        
        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'Company Created');
        return redirect()->back();
    }

    public function list(){
        $company = User::where('user_type',2)->get();
        // dd($company);
        return view('root.company.list',compact('company'));
    }

    public function companyUpdateAjax(Request $request){
        $company = User::where('id',$request->value)->first();
        // dd($company);
        return view('root.company.ajax.company-update',compact('company'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'c_name' => 'required',
            'c_phone' => 'required',
            'c_address' => 'required',
            
        ],[
            'c_name.required' => 'Company Name is Required',
            'c_phone.required' => 'Company Phone is Required',
            'c_address.required' => 'Company Address is Required',
            
        ]);
        
        
        $data = User::find($id);
        $data->name = $request->c_name;
        $data->contact_person = $request->c_person;
        $data->phone = $request->c_phone;
        $data->email = $request->c_email;
        if ($request->c_password != '') {
            $data->password = md5($request->c_password);
            $data->rawp = $request->c_password;
        }
        $data->address = $request->c_address;
        $data->user_type = 2; //Company Admin

        if ($request->hasfile('c_logo') != '') {
            $file = $request->file('c_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().random_int(10,99) . "." . $extension;
    
            $path = $request->c_logo->move('assets/image', $filename);
            $data->logo = $filename;
            
        }
        $data->save();
        session()->flash('type', 'success');
        session()->flash('message', 'Company Updated');
        return redirect()->route('root.company.list');
    }

    public function statusUpdate($id){
        $user = User::where('id',$id)->first();
        if ($user->status == 1) {
            User::where('id',$id)->update(['status' => 0]);
            session()->flash('type', 'danger');
            session()->flash('message', 'Company Deactivated');
            return redirect()->back();
        }else {
            User::where('id',$id)->update(['status' => 1]);
            session()->flash('type', 'success');
            session()->flash('message', 'Company Actived');
            return redirect()->back();
        }
        
    }

    public function permission(Request $request){
        $permission = User::where('id',$request->value)->first();
        return view('root.company.ajax.permission-update',compact('permission'));
    }

}
