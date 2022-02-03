<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function createCustomer(){
        return view('company.customer.create');
    }
    public function store(Request $request){
        $request->validate([
            'cus_name' => 'required',
            'cus_phone' => 'required',
            'cus_type' => 'required',
            
        ],[
            'cus_name.required' => 'Customer Name is Required',
            'cus_phone.required' => 'Customer Phone is Required',
            'cus_type.required' => 'Customer Type is Required',
            
        ]);
        $com = Auth::user()->company_id;
        $entryBy = Auth::user()->id;

        $data = new Customer();
        $data->	company_id = $com;
        $data->name = $request->cus_name;
        $data->com_name = $request->com_name;
        $data->email = $request->cus_email;
        $data->phone = $request->cus_phone;
        $data->address = $request->cus_address;
        $data->type = $request->cus_type;
        $data->entry_by = $entryBy;

        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'Customer Created');
        return redirect()->back();
    }

    public function customerList(){
        $com = Auth::user()->company_id;
        $customers = Customer::where('company_id',$com)->get();
        return view('company.customer.list',compact('customers'));
    }

    public function customerUpdateAjax(Request $request){
        $com = Auth::user()->company_id;
        $customer = Customer::where('company_id',$com)->where('id',$request->value)->first();
        return view('company.customer.ajax.update-customer',compact('customer'));
    }

    public function customerUpdate(Request $request,$id){
        $request->validate([
            'cus_name' => 'required',
            'cus_phone' => 'required',
            'cus_type' => 'required',
            
        ],[
            'cus_name.required' => 'Customer Name is Required',
            'cus_phone.required' => 'Customer Phone is Required',
            'cus_type.required' => 'Customer Type is Required',
            
        ]);
         
        $com = Auth::user()->company_id;
        $updatedBy = Auth::user()->id;

        $data = Customer::where('company_id',$com)->where('id',$id)->first();
        $data->	company_id = $com;
        $data->name = $request->cus_name;
        $data->com_name = $request->com_name;
        $data->email = $request->cus_email;
        $data->phone = $request->cus_phone;
        $data->address = $request->cus_address;
        $data->type = $request->cus_type;
        $data->entry_by = $updatedBy;

        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'Customer Updated');
        return redirect()->route('company.customer.customer-list');
    }
}
