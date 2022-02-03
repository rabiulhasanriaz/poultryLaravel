<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductGroup;
use App\Models\ProductType;
use App\Models\ProductDetail;
use App\Models\Supplier;
use Auth;
use Carbon\Carbon;

class ProductController extends Controller
{
    //Product Group
    public function groupAdd(){
        return view('inventory.product.group.add');
    }
    public function groupStore(Request $request){
        // dd($request->all());
        $request->validate([
            'g_name' => 'required|unique:product_groups,name',
        ],[
            'g_name.required' => 'Group Name is Required',
            'g_name.unique' => 'Group Name is Exist',
            
        ]);
        $com = Auth::user()->company_id;
        $entryBy = Auth::user()->id;

        $data = new ProductGroup();
        $data->company_id = $com;
        $data->name = $request->g_name;
        $data->entry_by = $entryBy;
        $data->updated_by = $entryBy;
        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'Group Added Successfully');
        return redirect()->back();
    }

    public function groupList(){
        $com = Auth::user()->company_id;
        $groups = ProductGroup::with('entryBy','updateBy')->where('company_id',$com)->get();
        return view('inventory.product.group.list',compact('groups'));
    }
    public function groupAjax(Request $request){
        $group = ProductGroup::where('id',$request->value)->first();
        return view('inventory.product.group.ajax.group-update',compact('group'));
    }
    public function groupUpdate(Request $request,$id){
        $request->validate([
            'g_name' => 'required|unique:product_groups,name',
        ],[
            'g_name.required' => 'Group Name is Required',
            'g_name.unique' => 'Group Name is Exist',
            
        ]);
        $com = Auth::user()->company_id;
        $entryBy = Auth::user()->id;

        $data = new ProductGroup();
        $data->company_id = $com;
        $data->name = $request->g_name;
        $data->updated_by = $entryBy;
        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'Group Updated Successfully');
        return redirect()->back();
    }
    //End Product Group
    //Product Type
    public function addType(){
        $com = Auth::user()->company_id;
        $groups = ProductGroup::where('company_id',$com)->get();
        return view('inventory.product.type.add',compact('groups'));
    }
    public function typeStore(Request $request){
        $request->validate([
            'g_id' => 'required',
            't_name' => 'required|unique:product_types,name',
        ],[
            'g_id.required' => 'Group Name is Required',
            't_name.required' => 'Type Name is Required',
            't_name.unique' => 'Type Name is Exist',
            
        ]);

        $com = Auth::user()->company_id;
        $entryBy = Auth::user()->id;
        $data = new ProductType();
        $data->company_id = $com;
        $data->group_id = $request->g_id;
        $data->name = $request->t_name;
        $data->entry_by = $entryBy;
        $data->updated_by = $entryBy;

        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'Type Added Successfully');
        return redirect()->back();

    }
    public function typeList(){
        $com = Auth::user()->company_id;
        $types = ProductType::with('groupName')->where('company_id',$com)->get();
        return view('inventory.product.type.list',compact('types'));
    }
    public function typeAjax(Request $request){
        $com = Auth::user()->company_id;
        $groups = ProductGroup::where('company_id',$com)->get();
        $type = ProductType::where('id',$request->value)->first();
        return view('inventory.product.type.ajax.type-update',compact('type','groups'));
    }
    public function typeUpdate(Request $request,$id){
        $request->validate([
            'g_id' => 'required',
            't_name' => 'required|unique:product_types,name',
        ],[
            'g_id.required' => 'Group Name is Required',
            't_name.required' => 'Type Name is Required',
            't_name.unique' => 'Type Name is Exist',
            
        ]);

        $com = Auth::user()->company_id;
        $entryBy = Auth::user()->id;
        $data = ProductType::where('id',$id)->first();
        $data->company_id = $com;
        $data->group_id = $request->g_id;
        $data->name = $request->t_name;
        $data->updated_by = $entryBy;

        $data->save();

        session()->flash('type', 'success');
        session()->flash('message', 'Type Updated Successfully');
        return redirect()->back();
    }
    //End Product Type

    //Product Add
    public function addProduct(){
        $com = Auth::user()->company_id;
        $groups = ProductGroup::where('company_id',$com)
                                ->where('status',1)
                                ->get();
        $suppliers = Supplier::where('company_id', $com)
                                ->where('status', 1)
                                ->where('type',3)
                                ->orderBy('company_name','ASC')
                                ->get();
        return view('inventory.product.add',compact('groups','suppliers'));
    }
    public function show_pro_type_by_ajax(Request $request) {
        $types = ProductType::where('group_id', $request->grp_id)
                                ->where('status',1)
                                ->get();
        return view('inventory.product.ajax.type-ajax', compact('types'));
    }
    public function productDetailSubmit(Request $request){
        // dd($request->all());
        $request->validate([
            'type' => 'required',
            'p_model' => 'required',
            'p_b_price' => 'required|numeric',
            'p_s_price' => 'required|numeric',
            'pro_desc' => 'max:50',
        ],[
            'type.required' => 'Type is Required',
            'p_model.required' => 'Product Model is Required',
            'p_b_price.required' => 'Buy Price is Required',
            'p_b_price.numeric' => 'Buy Price should be numeric',
            'p_s_price.numeric' => 'Sell Price should be numeric',
            'p_s_price.required' => 'Sell Price is required',
            'pro_desc.max' => 'Description Not more than 50 characters',
        ]);
            try{
            $submit_by = Auth::user()->id;
            $submit_at = Carbon::now()->format('Y-m-d H:i:s');
            $com = Auth::user()->company_id;
            $inv_pro_det = new ProductDetail;
            $inv_pro_det->company_id = $com;
            $inv_pro_det->type_id = $request->type;
            $inv_pro_det->supplier = implode('-',$request->supplier);
            $inv_pro_det->pro_name = $request->p_model;
            $inv_pro_det->buy_price = $request->p_b_price;
            $inv_pro_det->sell_price = $request->p_s_price;
            $inv_pro_det->pro_warranty = $request->pro_warranty;
            $inv_pro_det->pro_description = $request->pro_desc;
            $inv_pro_det->short_qty = $request->pro_short;
            $inv_pro_det->status = 1;
            $inv_pro_det->entry_by = $submit_by;
            $inv_pro_det->updated_by = $submit_by;
            $inv_pro_det->save();
            }catch(\Exception $e){
                session()->flash('type', 'danger');
                session()->flash('message', 'Something Went Wrong' . $e->getMessage());
                return redirect()->back();
            }
            session()->flash('type', 'success');
            session()->flash('message', 'Product Detail Added Successfully');
            return redirect()->back();
    }

    public function listProduct(){
            $com = Auth::user()->company_id;
            $products = ProductDetail::with('typeName')->where('company_id',$com)
                                      ->where('status',1)
                                      ->get();
                                    //   dd($products);
            return view('inventory.product.list',compact('products'));
    }
    //End Product Add
}
