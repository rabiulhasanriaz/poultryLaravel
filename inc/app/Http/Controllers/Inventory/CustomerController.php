<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\ProductInventory;
use App\Models\AccBankInfo;
use App\Models\AccBankStatement;
use App\Models\Project;

class CustomerController extends Controller
{
    // Customer add
    public function addCustomer(){
        return view('inventory.customer.customer.add');
    }
    public function customerStore(Request $request){
        $com = Auth::user()->company_id;
        $submit_by = Auth::user()->id;
        DB::beginTransaction();
        try{
            $request->validate([
                'c_name' => 'required',
                'c_mobile' => 'required',
            ],[
                'c_mobile.required' => 'Customer Mobile is Required',
                'c_name.required' => 'Customer Name is Required'
            ]);

            $inv_cus = new Customer;
            $inv_cus->company_id = $com;
            $inv_cus->cus_name = $request->c_name;
            $inv_cus->cus_com_name = $request->c_com_name;
            $inv_cus->cus_mobile = $request->c_mobile;
            $inv_cus->cus_email = $request->c_email;
            $inv_cus->cus_address = $request->c_address;
            $inv_cus->cus_customer_type = $request->c_type;
            $inv_cus->cus_website = $request->c_website;
            $inv_cus->cus_status = 1;
            $inv_cus->entry_by = $submit_by;
            $inv_cus->updated_by = $submit_by;
            $inv_cus->save();

            if ($request->c_balance > 0) {
                if ($request->c_bal_type == 1) {
                    $credit_amount = 0;
                    $debit_amount = $request->c_balance;
                } else {
                    $credit_amount = $request->c_balance;
                    $debit_amount = 0;
                }

                $new_memo_no = Customer::getNewCustomerMemoNo();
    
                $inv_cus_inv = new ProductInventory;
                $inv_cus_inv->company_id  = $com;
                $inv_cus_inv->party_id = $inv_cus->id;
                $inv_cus_inv->invoice_no = $new_memo_no;
                $inv_cus_inv->unit_price = 0;
                $inv_cus_inv->debit = $debit_amount;
                $inv_cus_inv->credit = $credit_amount;
                $inv_cus_inv->issue_date = Carbon::now();
                $inv_cus_inv->tran_desc = "Opening Balance";
                $inv_cus_inv->deal_type = 2;//2=customer
                $inv_cus_inv->tran_type = 3;//opening balance/ deposit withdraw
                $inv_cus_inv->status = 1;
                $inv_cus_inv->entry_by = $submit_by;
                $inv_cus_inv->updated_by = $submit_by;
                $inv_cus_inv->save();

            }
        }catch(\Exception $e){
            DB::rollback();
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Went Wrong'.$e->getMessage());
            return redirect()->back()->withInput();
        }
        DB::commit();
        session()->flash('type', 'success');
        session()->flash('message', 'Customer Added Successfully');
        return redirect()->back();
    }
    public function listCustomer(){
        $com = Auth::user()->company_id;
        $customers = Customer::where('company_id',$com)
                               ->where('cus_status',1)
                               ->get();
        return view('inventory.customer.customer.list',compact('customers'));
    }
    // Customer Accounts
    public function accountstatement(){
        $customers = Customer::where('company_id',Auth::user()->company_id)
					->where('cus_status',1)->get();
        return view('inventory.customer.customer-accounts.accountstatement',compact('customers'));
    }
    public function depositwithdraw(){
        $com = Auth::user()->company_id;
        $customers = Customer::where('company_id',$com)
                               ->where('cus_status',1)
                               ->get();
        return view('inventory.customer.customer-accounts.depositwithdraw',compact('customers'));
    }
    public function ajaxLoadCustomerBalance(Request $request){
        // dd($request->all());
        $com = Auth::user()->company_id;
        $customerBalance = DB::table('product_inventories')
                        ->select(DB::raw('SUM(debit-credit) as totalAmount'))
                        ->where('company_id',$com)
                        ->where('project_id',$request->customer_id)
                        ->where('deal_type',2)
                        ->whereIn('tran_type',[1,4,10,11,12])
                        
                        ->get();
		return view('inventory.customer.customer-accounts.ajax.available-balance-customer',compact('customerBalance'));
	}
    public function depositwithdrawStore(Request $request){
        try{
            $request->validate([
                      'c_name' => 'required',
                      'c_t_type' => 'required',
                      'c_t_date'=>'required|date',
                      'c_amount'=>'required|numeric|min:0',
                  ],[
                      'c_name.required' => 'Customer Name is Required',
                      'c_t_type.required' => 'Transaction Type is Required',
                      'c_t_date.required' => 'Transaction Date is Required',
                      'c_t_date.date' => 'Transaction date should be date',
                      'c_amount.required' => 'Amount is Required',
                      'c_amount.numeric' => 'Amount should be numeric',
                  ]);
  
              $inv_Pro_Invt=new ProductInventory();
              $inv_Pro_Invt->company_id=Auth::user()->company_id;
              $inv_Pro_Invt->party_id=$request->c_name;
              $inv_Pro_Invt->invoice_no=Carbon::now()->format('YmdHis');
              
              $inv_Pro_Invt->tran_desc=$request->c_reference;
              $inv_Pro_Invt->issue_date=$request->c_t_date;
              $inv_Pro_Invt->deal_type=2; //2 for customer dealing
              $inv_Pro_Invt->tran_type=3; // 3 fro opening,deposit and withdraw balance
              $inv_Pro_Invt->entry_by=Auth::user()->id;
              $inv_Pro_Invt->updated_by=Auth::user()->id;
  
              if($request->c_t_type==2)
              {
                  //credit
                  $inv_Pro_Invt->debit=0;
                  $inv_Pro_Invt->credit=$request->c_amount;
                  
              }
              else
                  if($request->c_t_type==3)
                  {
                      //Debit
                      $inv_Pro_Invt->debit=$request->c_amount;
                      $inv_Pro_Invt->credit=0;
                  }
                  if($inv_Pro_Invt->save()){
                        session()->flash('type', 'success');
                        session()->flash('message', 'Transaction Successfull.');
                        return redirect()->back();
                  }
                  else
                  {
                    session()->flash('type', 'danger');
                    session()->flash('message', 'Transaction Failed.Please Try Again.');
                    return redirect()->back();
                  }
  
          }catch(Exceptionn $err){
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Went Wrong' . $err->getMessage());
            return redirect()->back();
          }
    }
    public function paymentcollection(){
        $com = Auth::user()->company_id;
        $customers = Customer::where('company_id',$com)
                               ->where('cus_status',1)
                               ->get();
        $banks=AccBankInfo::where('company_id',Auth::user()->company_id)
                            ->where('status',1)->get();
        return view('inventory.customer.customer-accounts.payment',compact('customers','banks'));
    }

    public function show_project_ajax(Request $request) {
        $com = Auth::user()->company_id;
        $projects = Project::where('company_id',$com)->where('customer', $request->cus_id)
                                ->where('status',1)
                                ->get();
        return view('inventory.customer.customer-accounts.ajax.project-ajax', compact('projects'));
    }

    public function ajaxLoadBankBalance(Request $request){
        $bankBalance = DB::table('acc_bank_statements')
                        ->select(DB::raw('SUM(credit - debit) as total'))
                        ->where('bank_id',$request->bank_id)
                        ->where('company_id',Auth::user()->company_id)
                        ->get();		

		return view('inventory.customer.customer-accounts.ajax.available-balance-bank',compact('bankBalance'));
	}
    public function paymentcollectionStore(Request $request){
        try{
			$request->validate([
			            'p_t_date' => 'required|date',
			            'c_name'=>'required',
			            'p_amount'=>'required|numeric|min:0',
			            'p_discount'=>'nullable|numeric|min:0',
			        ],[
                        'p_t_date.required' => 'Transaction Date is required',
                        'p_t_date.date' => 'Transaction Date should be date',
                        'c_name.required' => 'Customer is required',
                        'p_amount.required' => 'Amount is required',
                        'p_amount.numeric' => 'Amount should be numeric',
                        'p_discount.numeric' => 'Discount should be numeric',
                    ]);

			$inv_Pro_Invt=new ProductInventory();
			$invoiceNo=Carbon::now()->format('YmdHis');
			$inv_Pro_Invt->company_id=Auth::user()->company_id;
			$inv_Pro_Invt->party_id=$request->c_name;
			$inv_Pro_Invt->project_id=$request->project;
			$inv_Pro_Invt->debit=0;
			$inv_Pro_Invt->credit=$request->p_amount;
			$inv_Pro_Invt->deal_type=2; // 2 for customer
			$inv_Pro_Invt->tran_type=4; // 4 for customer payment collection
			$inv_Pro_Invt->tran_desc=$request->p_reference;
			$inv_Pro_Invt->issue_date=$request->p_t_date;
			$inv_Pro_Invt->invoice_no=$invoiceNo;
			$inv_Pro_Invt->entry_by=Auth::user()->id;
			$inv_Pro_Invt->updated_by=Auth::user()->id;
			$inv_Pro_Invt->save();


			
			$inv_Acc_Bank_Statement = new AccBankStatement();
            $inv_Acc_Bank_Statement->company_id = Auth::user()->company_id;
            $inv_Acc_Bank_Statement->reference_id = $request->c_name;
            $inv_Acc_Bank_Statement->bank_id = $request->b_id;
            $inv_Acc_Bank_Statement->inventory_id=$inv_Pro_Invt->id;
            $inv_Acc_Bank_Statement->debit = 0;
            $inv_Acc_Bank_Statement->credit =$request->p_amount ;
            $inv_Acc_Bank_Statement->transaction_date = $request->p_t_date;
            $inv_Acc_Bank_Statement->description = $request->p_reference;
            $inv_Acc_Bank_Statement->voucher_no=$invoiceNo;
            $inv_Acc_Bank_Statement->status = 1;
            $inv_Acc_Bank_Statement->reference_type = 1; //1= Customer Payment Collection
            $inv_Acc_Bank_Statement->entry_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->updated_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->save();


            if($request->p_discount>0)
            {
            	$inv_Pro_Invt1=new ProductInventory();
				
				$inv_Pro_Invt1->company_id=Auth::user()->company_id;
				$inv_Pro_Invt1->party_id=$request->c_name;
				$inv_Pro_Invt1->debit=0;
				$inv_Pro_Invt1->credit=$request->p_discount;
				$inv_Pro_Invt1->deal_type=2; // 2 for customer
				$inv_Pro_Invt1->tran_type=6; // 6 Customer or Supplier Discount
				$inv_Pro_Invt1->tran_desc=$request->p_reference.' Customer Discount - '.$request->p_discount;
				$inv_Pro_Invt1->issue_date=$request->p_t_date;
				$inv_Pro_Invt1->invoice_no=$invoiceNo;
				$inv_Pro_Invt1->entry_by=Auth::user()->id;
				$inv_Pro_Invt1->updated_by=Auth::user()->id;
				$inv_Pro_Invt1->save();
            }
            session()->flash('type', 'success');
            session()->flash('message', 'Payment Successfull.');
            return redirect()->back();
		}catch(Exceptionn $err){
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Went Wrong' . $err->getMessage());
            return redirect()->back();
		}
    }
    public function paymentrefund(){
        $com = Auth::user()->company_id;
        $customers = Customer::where('company_id',$com)
                               ->where('cus_status',1)
                               ->get();
        $banks=AccBankInfo::where('company_id',Auth::user()->company_id)
                            ->where('status',1)->get();
        return view('inventory.customer.customer-accounts.paymentrefund',compact('customers','banks'));
    }

    public function paymentRefundStore(Request $request){
        try{

			$request->validate([
			            'p_t_date' => 'required|date',
			            'p_amount'=>'required|numeric|min:0',
			            'c_name'=>'required',
			        ],[
                        'p_t_date.required' => 'Transaction Date is required',
                        'p_t_date.date' => 'Transaction Date should be date',
                        'p_amount.required' => 'Amount is Required',
                        'p_amount.numeric' => 'Amount should be numeric',
                        'c_name.required' => 'Customer Name is required',
                    ]);
			$balance=AccBankStatement::getAvailableBalanceByBankId($request->b_id);
			if($balance>=$request->p_amount){
			$inv_Pro_Invt=new ProductInventory();
			$inv_Pro_Invt->company_id=Auth::user()->company_id;
			$inv_Pro_Invt->party_id=$request->c_name;
			$inv_Pro_Invt->debit=$request->p_amount;
			$inv_Pro_Invt->credit=0;
			$inv_Pro_Invt->tran_type=5; //5=customer payment refunds
			$inv_Pro_Invt->invoice_no=Carbon::now()->format('YmdHis');
			$inv_Pro_Invt->tran_desc=$request->p_reference;
			$inv_Pro_Invt->issue_date=$request->p_t_date;
			$inv_Pro_Invt->deal_type=2;// 2 for customer
			$inv_Pro_Invt->entry_by=Auth::user()->id;
			$inv_Pro_Invt->updated_by=Auth::user()->id;
			$inv_Pro_Invt->save();


			
			$inv_Acc_Bank_Statement = new AccBankStatement();
            $inv_Acc_Bank_Statement->company_id = Auth::user()->company_id;
            $inv_Acc_Bank_Statement->reference_id = $request->c_name;
            $inv_Acc_Bank_Statement->bank_id = $request->b_id;
            $inv_Acc_Bank_Statement->inventory_id=$inv_Pro_Invt->id;
            $inv_Acc_Bank_Statement->debit = $request->p_amount;
            $inv_Acc_Bank_Statement->credit =0;
            $inv_Acc_Bank_Statement->transaction_date = $request->p_t_date;
            $inv_Acc_Bank_Statement->description = $request->p_reference;
            $inv_Acc_Bank_Statement->voucher_no=Carbon::now()->format('YmdHis');
            $inv_Acc_Bank_Statement->status = 1;
            $inv_Acc_Bank_Statement->reference_type = 1; //1= Customer Payment Collection
            $inv_Acc_Bank_Statement->entry_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->updated_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->save();

            session()->flash('type', 'success');
            session()->flash('message', 'Payment Successfull.');
            return redirect()->back();
        }else{
            session()->flash('type', 'danger');
            session()->flash('message', 'Insufficent Balance Found.');
            return redirect()->back()->withInput();
        }

		}catch(Exceptionn $err){
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Went Wrong' . $err->getMessage());
            return redirect()->back();
		}
    }
}
