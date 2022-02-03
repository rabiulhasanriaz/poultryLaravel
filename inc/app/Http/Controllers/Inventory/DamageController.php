<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\ProductGroup;
use App\Models\ProductType;
use App\Models\ProductDetail;
use App\Models\ProductInventory;

class DamageController extends Controller
{
    public function damage_add(){
        $com = Auth::user()->company_id;
        $pro_grp = ProductGroup::where('company_id',$com)
                                ->where('status',1)
                                ->get();
        return view('inventory.damage.add',compact('pro_grp'));
    }

    public function show_pro_grp_by_ajax(Request $request) {
        $types = ProductType::where('group_id', $request->grp_id)
                                ->where('status',1)
                                ->get();
        return view('inventory.damage.ajax.product-type', compact('types'));
    }

    public function show_pro_name_ajax(Request $request) {
        $types = ProductDetail::where('type_id', $request->model_id)
                                ->where('status',1)
                                ->get();
        return view('inventory.damage.ajax.pro-name', compact('types'));
    }

    public function damage_add_submit(Request $request){
        // dd($request->all());
        $com = Auth::user()->company_id;
        $submit_by = Auth::user()->id;

    try {
        $request->validate([
            'product' => 'required',
            'd_qty' => 'required',
        ],[
            'product.required' => 'Product Name is Required',
            'd_qty.required' => 'Damage Quantity is Required'
        ]);

        $damage = new ProductInventory;
        $damage->company_id = $com;
        $damage->prodet_id = $request->product;
        $damage->total_qty = $request->d_qty;
        $damage->short_qty = 0;
        $damage->qty = $request->d_qty;
        $damage->deal_type = 2;
        $damage->damage_status = 1;
        $damage->tran_type = 1;
        $damage->entry_by = $submit_by;
        $damage->updated_by = $submit_by;
        $damage->save();
        
    } catch (\Exception $e) {
        session()->flash('type', 'danger');
        session()->flash('message', 'Something Went Wrong'.$e->getMessage());
        return redirect()->back();
    }
    session()->flash('type', 'success');
    session()->flash('message', 'Damage Product Submitted Successfully');
    return redirect()->back();
    }

    public function damage_list(){
        $com = Auth::user()->company_id;
        $damage_list = ProductInventory::where('company_id',$com)
                                         ->where('deal_type',2)
                                         ->where('damage_status',1)
                                         ->where('tran_type',1)
                                         ->get();
        return view('inventory.damage.list',compact('damage_list'));
    }
}
