<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\ProductInventory;

class ReportsController extends Controller
{
    public function sell_reports(Request $request){  
        // dd($request->all());  
        $com = Auth::user()->company_id;

        if ($request->has('searchbtn')) {
            $request->validate([
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]);
            $sell_reports=ProductInventory::where('company_id',$com)
                                        ->where('issue_date','>=',$request->start_date)
                                        ->where('issue_date','<=',$request->end_date)
                                        ->where('status',1)
                                        ->where('deal_type',2)
                                        ->whereIn('tran_type',[1,10,11,12])
                                        ->where('confirm',0)
                                        ->groupBy('invoice_no')
                                        ->get();
                                            
        }else{
            $sell_reports = ProductInventory::where('company_id',$com)
                                            ->where('deal_type',2)
                                            ->whereIn('tran_type',[1,10,11,12])
                                            ->where('confirm',0)
                                            ->groupBy('invoice_no')
                                            ->get();
                                            // dd($sell_reports);
                                                
        }
        return view('inventory.reports.sale.sell-report',compact('sell_reports'));
    }

    public function sell_report_ajax(Request $request){
        $detail_ajax = ProductInventory::where('invoice_no',$request->sell_id)
                                            ->where('deal_type',2)
                                            ->whereIn('tran_type',[1,10,11])
                                            ->get();

        $discount = ProductInventory::where('invoice_no',$request->sell_id)
                                        ->where('deal_type',2)
                                        ->where('tran_type',12)
                                        ->first();
        if (!empty($discount)) {
            $discount_amount = $discount->credit;
        }else {
            $discount_amount = 0;
        }
                        
        return view('inventory.reports.sale.ajax.sell-reports-ajax',compact('detail_ajax','discount_amount'));

    }

    public function buy_reports(Request $request){
     
      
        $com = Auth::user()->company_id;
       
        if ($request->has('searchbtn')) {
            $request->validate([
                   'start_date' => 'required',
                   'end_date' => 'required',
               ]);
           $buy_reports=ProductInventory::where('company_id',$com)
                                        ->where('issue_date','>=',$request->start_date)
                                        ->where('issue_date','<=',$request->end_date)
                                        ->where('status',1)
                                        ->where('deal_type',1)
                                        ->where('tran_type',1)
                                        ->where('confirm',0)
                                        ->groupBy('invoice_no')
                                        ->get();
       }else{
        $buy_reports = ProductInventory::where('company_id',$com)
                                        ->where('deal_type',1)
                                        ->where('tran_type',1)
                                        ->where('confirm',0)
                                        ->groupBy('invoice_no')
                                        ->get();
       }
        return view('inventory.reports.buy.buy-reports',compact('buy_reports'));
        
    }

    public function buy_reports_ajax(Request $request){
        $detail_buy = ProductInventory::where('invoice_no',$request->buy_id)->get();
        return view('inventory.reports.buy.ajax.buy-report-ajax',compact('detail_buy'));
    }
}
