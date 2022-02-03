<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\AccBankInfo;
use App\Models\AccBankStatement;

class BankController extends Controller
{
    //
    public function addbank(){
        $banks = Bank::where('status',1)->get();
        return view('inventory.accounts.bank.add',compact('banks'));
    }
    public function storeBank(Request $request){
        $request->validate([
            'b_name' => 'required',
            'br_name' => 'required',
            'ac_name' => 'required|unique:acc_bank_infos,account_name',
            'ac_no' => 'required|unique:acc_bank_infos,account_no',
            'open_date' => 'required',
        ],[
            'b_name.required' => 'Bank Name is Required',
            'br_name.required' => 'Branch Name is Required',
            'ac_name.unique' => 'Account Name is Exist',
            'ac_no.unique' => 'Account No is Exist',
            'open_date.required' => 'Open Date is Required',
            
        ]);
        
			$company_id=Auth::user()->company_id;
			$userid=Auth::user()->id;

			$new_bank = new AccBankInfo();
			$new_bank->company_id = $company_id;
			$new_bank->bank_id = $request->b_name;
			$new_bank->branch_name = $request->br_name;
			$new_bank->account_name = ucfirst($request->ac_name);
			$new_bank->account_no = $request->ac_no;
			$new_bank->open_date = $request->open_date;
			$new_bank->account_type = 1; //1==bank
			$new_bank->entry_by = $userid;
			$new_bank->updated_by = $userid;

			$new_bank->save();

            session()->flash('type', 'success');
            session()->flash('message', 'Bank Added Successfully Completed');
            return redirect()->back();
    }
    public function listbank(){
        $com = Auth::user()->company_id;

		$bank_infos = AccBankInfo::with('bank_info')->where('company_id', $com)
								->where('status', 1)
								->get();
        return view('inventory.accounts.bank.list',compact('bank_infos'));
    }
    public function dipositwithdraw(){
        $banks = AccBankInfo::where('company_id',Auth::user()->company_id)->get();
        return view('inventory.accounts.bank.dipositwithdraw',compact('banks'));
    }
    public function depostiWithdrawStore(Request $request){
        $request->validate([
            'b_id' => 'required',
            'b_type' => 'required',
            't_date' => 'required',
            'tr_amnt' => 'required|numeric||min:0',
        ],[
            'b_id.required' => 'Bank Name is Required',
            'b_type.required' => 'Balance Type is Required',
            't_date.required' => 'Transaction Date is Required',
            'tr_amnt.required' => 'Transaction Amount is Required',
            'tr_amnt.numeric' => 'Transaction Amount should be numeric',
            
        ]);
        $bank = AccBankInfo::where('id',$request->b_id)
        ->where('company_id',Auth::user()->company_id)->first();
        // dd($bank);
        try{
			if($bank){
				$inv_Acc_Statement=new AccBankStatement();
				$inv_Acc_Statement->company_id=Auth::user()->company_id;
				//$inv_Acc_Statement->inv_abs_inventory_id=
				// $inv_Acc_Statement->inv_abs_reference_id=$request->expense_id;// balance 3 for credit and 4 for debit
				$inv_Acc_Statement->reference_type= $request->b_type;
				$inv_Acc_Statement->bank_id=$request->b_id;
				
				$inv_Acc_Statement->transaction_date=$request->t_date;
				$inv_Acc_Statement->voucher_no=Carbon::now()->format('YmdHis');
				$inv_Acc_Statement->description=$request->ref;
				$inv_Acc_Statement->entry_by=Auth::user()->id;
				$inv_Acc_Statement->updated_by=Auth::user()->id;
				
				if($request->b_type==6){
					$inv_Acc_Statement->credit = $request->tr_amnt;
					$inv_Acc_Statement->debit = 0;
                }
				else{
					$inv_Acc_Statement->credit=0;
					$inv_Acc_Statement->debit = $request->tr_amnt;
				}

				if($inv_Acc_Statement->save()){
                    session()->flash('type', 'success');
                    session()->flash('message', 'Successfully Added.');
                    return redirect()->back();
				}else{
                    session()->flash('type', 'danger');
                    session()->flash('message', 'Failed To Add.Please Try Again.');
                    return redirect()->back();
				}
			}else{
                session()->flash('type', 'danger');
                session()->flash('message', 'The Bank You Selected is Not Belongs to Your Company.');
                return redirect()->back();
			}
		}
		catch(Exception $err){
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Goes Wrong.Please Try Again Later'.$err->getMessage());
            return redirect()->back();
		}
    }

    public function ajaxLoadBankBalance(Request $request){
        $bankBalance = DB::table('acc_bank_statements')
                        ->select(DB::raw('SUM(credit - debit) as total'))
                        ->where('bank_id',$request->bank_id)
                        ->where('company_id',Auth::user()->company_id)
                        ->get();		

		return view('inventory.accounts.bank.ajax.available-balance-bank',compact('bankBalance'));
	}
}
