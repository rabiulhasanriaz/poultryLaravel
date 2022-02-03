<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Supplier;
use App\Models\ProductInventory;
use App\Models\AccBankInfo;
use App\Models\AccBankStatement;

class SupplierController extends Controller
{
    //Supplier
    public function addSupplier(){
        return view('inventory.supplier.supplier.add');
    }
    public function supplierStore(Request $request){
        $com = Auth::user()->company_id;
        $user = Auth::user()->id;
        $time = Carbon::now();

        $request->validate([
            'c_name' => 'required',
            's_address' => 'required',
            's_person' => 'required',
            's_mobile' => 'required',
            's_type' => 'required',
        ],[
            'c_name.required' => 'Supplier Company Name is Required',
            's_address.required' => 'Supplier Addres is Required',
            's_person.required' => 'Person Name is Required',
            's_mobile.required' => 'Supplier Mobile is Required',
            's_type.required' => 'Supplier Type is Required',
            
        ]);

        DB::beginTransaction();
        try {

            $sup = new Supplier();
            $sup->company_id = $com;
            $sup->company_name = $request->c_name;
            $sup->address = $request->s_address;
            $sup->person = $request->s_person;
            $sup->mobile = $request->s_mobile;
            $sup->phone = $request->s_phone;
            $sup->email = $request->s_email;
            $sup->website = $request->s_website;
            $sup->complain_number = $request->s_complain;
            $sup->type = $request->s_type;
            $sup->due_balance = $request->s_due_bal;
            $sup->balance_type = $request->s_bal_type;
            $sup->status = 1;
            $sup->entry_by = $user;
            $sup->update_by = $user;
            $sup->save();

            if ($request->s_due_bal > 0) {
                if ($request->s_bal_type == 1) {
                    $credit_amount = 0;
                    $debit_amount = $request->s_due_bal;
                } else {
                    $credit_amount = $request->s_due_bal;
                    $debit_amount = 0;
                }
                $new_memo_no = Supplier::getNewSupplierMemoNo();
                // dd($new_memo_no);
    
                $inv_sup_inv = new ProductInventory();
                $inv_sup_inv->company_id  = $com;
                $inv_sup_inv->party_id = $sup->id;
                $inv_sup_inv->invoice_no = $new_memo_no;
                $inv_sup_inv->unit_price = 0;
                $inv_sup_inv->debit = $debit_amount;
                $inv_sup_inv->credit = $credit_amount;
                $inv_sup_inv->issue_date = Carbon::now();
                $inv_sup_inv->tran_desc = "Opening Balance";
                $inv_sup_inv->deal_type = 1;//2=supplier
                $inv_sup_inv->tran_type = 3;//opening balance/ deposit withdraw
                $inv_sup_inv->status = 1;
                $inv_sup_inv->entry_by = $user;
                $inv_sup_inv->updated_by = $user;
                $inv_sup_inv->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Went Wrong'.$e->getMessage());
            return redirect()->back();
        }
        DB::commit();
        session()->flash('type', 'success');
        session()->flash('message', 'Supplier Added Successfully');
        return redirect()->back();
    }
    public function supplierList(){
        $com = Auth::user()->company_id;
        $suppliers = Supplier::where('company_id',$com)->where('status',1)->get();
        return view('inventory.supplier.supplier.list',compact('suppliers'));
    }
    //End Supplier

    //Supplier Accounts
    public function depositWithdraw(){
        $suppliers = Supplier::where('company_id',Auth::user()->company_id)
                             ->where('status',1)
                             ->get();
                            //  dd($suppliers );
        return view('inventory.supplier.supplier_account.deposit-withdraw',compact('suppliers'));
    }
    public function supplierBalanceAjax(Request $request){
        $supplierBalance = DB::table('product_inventories')
                            ->select(DB::raw('SUM(credit-debit) as total'))
                            ->where('party_id',$request->supplier_id)
                            ->where('company_id',Auth::user()->company_id)
                            ->where('deal_type',1)
                            ->get();
			 
		return view('inventory.supplier.supplier_account.ajax.supplier-balance',compact('supplierBalance'));
    }
    public function depositWithdrawStore(Request $request){
        try{
			
			$request->validate([
			            's_t_date' => 'required|date',
			            's_amount'=>'required|numeric|min:0',
			            's_name'=>'required',
			            's_t_type'=>'required',
			],
                [
                    's_t_date.required' => 'Transaction is Required',
                    's_amount.required' => 'Amount is Required',
                    's_amount.numeric' => 'Amount Should be Numeric',
                    's_name.required' => 'Supplier is Required',
                    's_t_type.required' => 'Transaction Type is Required',
                ]
            );
			
			$inv_Pro_Invt=new ProductInventory();
			$inv_Pro_Invt->company_id=Auth::user()->company_id;
			$inv_Pro_Invt->party_id=$request->s_name;
			$inv_Pro_Invt->tran_type=3; // for opening,deposit and withdraw balance
			$inv_Pro_Invt->invoice_no=Carbon::now()->format('YmdHis');
			$inv_Pro_Invt->deal_type=1; // for supplier 
			$inv_Pro_Invt->tran_desc=$request->s_reference;
			$inv_Pro_Invt->issue_date=$request->s_t_date;
			$inv_Pro_Invt->status=1;
			$inv_Pro_Invt->entry_by=Auth::user()->id;
			$inv_Pro_Invt->updated_by=Auth::user()->id;

			if($request->s_t_type==2)
			{
				//credit
				$inv_Pro_Invt->debit=0;
				$inv_Pro_Invt->credit=$request->s_amount;
				
			}
			else
				if($request->s_t_type==3)
				{
					//Debit
					$inv_Pro_Invt->debit=$request->s_amount;
					$inv_Pro_Invt->credit=0;

				}

				if($inv_Pro_Invt->save())
				{
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

		}
		catch(Exceptionn $err)
		{
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Went Wrong'.$e->getMessage());
			Session::flash('errmsg','Something Went Wrong.');
			return redirect()->back();
		}
    }

    public function supplierPayment(){
        $banks=AccBankInfo::where('company_id',Auth::user()->company_id)
				->where('status',1)->get();
		$suppliers=Supplier::where('company_id',Auth::user()->company_id)
						->where('status',1)->get();
        return view('inventory.supplier.supplier_account.payment',compact('banks','suppliers'));
    }

    public function ajaxLoadBankBalance(Request $request){
        $bankBalance = DB::table('acc_bank_statements')
                        ->select(DB::raw('SUM(credit - debit) as total'))
                        ->where('bank_id',$request->bank_id)
                        ->where('company_id',Auth::user()->company_id)
                        ->get();		

		return view('inventory.supplier.supplier_account.ajax.available-balance-bank',compact('bankBalance'));
	}

    public function supplierPaymentStore(Request $request){
        $request->validate([
            's_name' => 'required',
            'b_id' => 'required',
            'p_t_date' => 'required|date',
            'p_amount' => 'required|numeric',
        ],[
            's_name.required' => 'Supplier Name is Required',
            'b_id.required' => 'Bank is Required',
            'p_t_date.required' => 'Payment Transaction Date is Required',
            'p_t_date.date' => 'Payment Transaction Date should be Date',
            'p_amount.required' => 'Amount is Required',
            'p_amount.numeric' => 'Amount Should be numeric',
        ]);

        try{

			$balance=AccBankStatement::getAvailableBalanceByBankId($request->b_id);
		if($balance>= $request->p_amount){

			$inv_Pro_Invt=new ProductInventory();
			$invoiceNo=Carbon::now()->format('YmdHis');
			$inv_Pro_Invt->company_id=Auth::user()->company_id;
			$inv_Pro_Invt->party_id=$request->s_name;
			$inv_Pro_Invt->debit=0;
			$inv_Pro_Invt->credit=$request->p_amount;
			$inv_Pro_Invt->tran_type=4; //for suppliers payments
			$inv_Pro_Invt->deal_type=1; // for supplier
			$inv_Pro_Invt->tran_desc=$request->p_reference;
			$inv_Pro_Invt->issue_date=$request->p_t_date;
			$inv_Pro_Invt->invoice_no=$invoiceNo;
			$inv_Pro_Invt->status=1;
			$inv_Pro_Invt->entry_by=Auth::user()->id;
			$inv_Pro_Invt->updated_by=Auth::user()->id;
			$inv_Pro_Invt->save();


			
			 $inv_Acc_Bank_Statement = new AccBankStatement();
            $inv_Acc_Bank_Statement->company_id = Auth::user()->company_id;
            $inv_Acc_Bank_Statement->reference_id = $request->s_name;
            $inv_Acc_Bank_Statement->bank_id = $request->b_id;
            $inv_Acc_Bank_Statement->inventory_id=$inv_Pro_Invt->id;
            $inv_Acc_Bank_Statement->debit = $request->p_amount;
            $inv_Acc_Bank_Statement->credit = 0;
            $inv_Acc_Bank_Statement->transaction_date = $request->p_t_date;
            $inv_Acc_Bank_Statement->description= $request->p_reference;
            $inv_Acc_Bank_Statement->voucher_no=Carbon::now()->format('YmdHis');
            $inv_Acc_Bank_Statement->status = 1;
            $inv_Acc_Bank_Statement->reference_type = 2; //2= Supplier Payment
            $inv_Acc_Bank_Statement->entry_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->updated_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->save();


            if($request->p_discount>0)
            {
            	$inv_Pro_Invt1=new ProductInventory();
				
				$inv_Pro_Invt1->company_id=Auth::user()->company_id;
				$inv_Pro_Invt1->party_id=$request->s_name;
				$inv_Pro_Invt1->debit=0;
				$inv_Pro_Invt1->credit=$request->p_discount;
				$inv_Pro_Invt1->deal_type=1; //  1 for supplier
				$inv_Pro_Invt1->tran_type=6; // 6 Customer or Supplier Discount
				$inv_Pro_Invt1->tran_desc=$request->p_reference.' Supplier Discount - '.$request->p_discount;
				$inv_Pro_Invt1->issue_date=$request->p_t_date;
				$inv_Pro_Invt1->invoice_no=$invoiceNo;
				$inv_Pro_Invt1->entry_by=Auth::user()->id;
				$inv_Pro_Invt1->updated_by=Auth::user()->id;
				$inv_Pro_Invt1->save();
            }

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
            session()->flash('message', 'Something Went Wrong.'.$err->getMessage());
            return redirect()->back();
		}
    }
    
    public function supplierPaymentCollection(){
        $banks=AccBankInfo::where('company_id',Auth::user()->company_id)
				->where('status',1)->get();
		$suppliers=Supplier::where('company_id',Auth::user()->company_id)
						->where('status',1)->get();
        return view('inventory.supplier.supplier_account.payment-collection',compact('banks','suppliers'));
    }
    public function paymentCollectionStore(Request $request){
        try{
			$request->validate([
			            'p_t_date' => 'required|date',
			            'p_amount'=>'required|numeric|min:0',
			            's_name'=>'required',
			            'b_id'=>'required',
			],
            [
                'p_t_date.required' => 'Transaction Date is Required',
                'p_t_date.date' => 'Transaction Date Should be Date',
                'p_amount.required' => 'Amount is Required',
                'p_amount.numeric' => 'Amount Should be Numeric',
                's_name.required' => 'Supplier is Required',
                'b_id.required' => 'Method is Required'
            ]);
			
			$inv_Pro_Invt=new ProductInventory();
			$inv_Pro_Invt->company_id=Auth::user()->company_id;
			$inv_Pro_Invt->party_id=$request->s_name;
			$inv_Pro_Invt->debit=$request->p_amount;
			$inv_Pro_Invt->credit=0;
			$inv_Pro_Invt->tran_type=5; // 5=payment collection 
			$inv_Pro_Invt->deal_type=1; // for supplier
			$inv_Pro_Invt->invoice_no=Carbon::now()->format('YmdHis');
			$inv_Pro_Invt->tran_desc=$request->p_reference;
			$inv_Pro_Invt->issue_date=$request->p_t_date;
			$inv_Pro_Invt->status=1;
			$inv_Pro_Invt->entry_by=Auth::user()->id;
			$inv_Pro_Invt->updated_by=Auth::user()->id;
			$inv_Pro_Invt->save();


			
			$inv_Acc_Bank_Statement = new AccBankStatement();
            $inv_Acc_Bank_Statement->company_id = Auth::user()->company_id;
            $inv_Acc_Bank_Statement->reference_id = $request->s_name;
            $inv_Acc_Bank_Statement->bank_id = $request->b_id;
            $inv_Acc_Bank_Statement->inventory_id=$inv_Pro_Invt->id;
            $inv_Acc_Bank_Statement->debit = 0;
            $inv_Acc_Bank_Statement->credit = $request->p_amount;
            $inv_Acc_Bank_Statement->transaction_date = $request->p_t_date;
            $inv_Acc_Bank_Statement->description= $request->p_reference;
            $inv_Acc_Bank_Statement->voucher_no=Carbon::now()->format('YmdHis');
            $inv_Acc_Bank_Statement->status = 1;
            $inv_Acc_Bank_Statement->reference_type = 2; //2= Supplier Payment
            $inv_Acc_Bank_Statement->entry_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->updated_by = Auth::user()->id;
            $inv_Acc_Bank_Statement->save();

            session()->flash('type', 'success');
            session()->flash('message', 'Payment Successfull.');
            return redirect()->back();
		}catch(Exceptionn $err){
            session()->flash('type', 'danger');
            session()->flash('message', 'Something Went Wrong'.$err->getMessage());
            return redirect()->back();
		}
    }

    public function accountStatements(){
        $suppliers= Supplier::where('company_id',Auth::user()->company_id)
					->where('status',1)
					->get();
        return view('inventory.supplier.supplier_account.account-statements',compact('suppliers'));
    }
    //End Supplier Accounts
}
