<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ProductInventory;

class ProjectController extends Controller
{
    public function projectAdd(){
        $com = Auth::user()->company_id;
        $customers = Customer::where('company_id',$com)->where('cus_status',1)->get();
        return view('inventory.project.add',compact('customers'));
    }

    public function projectStore(Request $request){
        $request->validate([
            'p_name' => 'required|unique:projects,name',
            'c_id' => 'required',
            'issue' => 'required'
        ],[
            'p_name.required' => 'Project Name is Required',
            'p_name.unique' => 'Project Name is Exist',
            'c_id.required' => 'Customer is Required',
            'issue.required' => 'Issue Date is Required',
        ]);

        $com = Auth::user()->company_id;
        $user = Auth::user()->id;

        $data = new Project;
        $data->company_id = $com;
        $data->name = $request->p_name;
        $data->customer = $request->c_id;
        $data->issue_date = $request->issue;
        $data->entry_by = $user;
        $data->update_by = $user;

        $data->save();
        session()->flash('type', 'success');
        session()->flash('message', 'Project Created Successfully');
        return redirect()->back();
    }

    public function projectList(){
        $com = Auth::user()->company_id;
        $projects = Project::with('customerInfo')->where('company_id',$com)->groupBy('customer')->get();
        return view('inventory.project.list',compact('projects'));
    }

    public function projectDetails($id){
        $com = Auth::user()->company_id;
        $customer = Project::where('company_id',$com)->where('customer',$id)->first();
        $details = Project::where('company_id',$com)->where('customer',$id)->get();
        return view('inventory.project.project-details',compact('details','customer'));
    }

    public function projectInvoice($id){
        $com = Auth::user()->company_id;
        $project = Project::where('company_id',$com)->where('id',$id)->first();
        $invoices = DB::table('product_inventories')
                        ->select('issue_date','invoice_no',DB::raw('SUM(debit) as totalDebit'),DB::raw('SUM(credit) as totalCredit'),DB::raw('SUM(debit-credit) as totalAmount'))
                        ->where('company_id',$com)
                        ->where('project_id',$id)
                        ->where('deal_type',2)
                        ->whereIn('tran_type',[1,4,10,11,12])
                        
                        ->get();
        return view('inventory.project.invoice-details',compact('invoices','project'));
    }

    public function invoiceReportAjax(Request $request){
        $detail_ajax = ProductInventory::where('invoice_no',$request->invoice)
                                            ->where('deal_type',2)
                                            ->whereIn('tran_type',[1,10,11])
                                            ->get();

        $discount = ProductInventory::where('invoice_no',$request->invoice)
                                        ->where('deal_type',2)
                                        ->where('tran_type',12)
                                        ->first();
        if (!empty($discount)) {
            $discount_amount = $discount->credit;
        }else {
            $discount_amount = 0;
        }
                        
        return view('inventory.project.ajax.invoice-report-ajax',compact('detail_ajax','discount_amount'));
    }
}
