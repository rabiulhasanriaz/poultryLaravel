<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Supplier;
use App\Models\ProductDetail;
use App\Models\ProductTemporary;
use App\Models\ProductInventory;
use App\Models\ProductInventoryDetail;

class ProductBuyController extends Controller
{
    public function addProduct(){
        $com = Auth::user()->company_id;
        $suppliers = Supplier::where('company_id',$com)
                                 ->where('status',1)
                                 ->orderBy('company_name','ASC')
                                 ->get();
        $products = ProductDetail::where('company_id',$com)
                                ->where('status',1)
                                ->orderBy('pro_name','ASC')                                           
                                ->get();
        return view('inventory.product-inventory.purchase.add',compact('suppliers','products'));
    }

    public function addToCart(Request $request){
        // dd($request->all());
        $product = ProductDetail::where('id', $request->pro_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('status', 1)
            ->first();
        if ($request->short_qty == 'NaN') {
            $shortQty = 0;
        }else {
            $shortQty = $request->short_qty;
        }
        if(!empty($product)) {
            
            $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->pro_id)
                ->where('deal_type',1)
                ->first();
            if(!empty($row)) {
                $row->pro_name = $product->pro_name;
                $row->type_name = ProductDetail::get_type_name($product->id);
                $row->short_qty = $shortQty;
                $row->qty = $request->pro_qty;
                $row->short_remarks = $request->remarks;
                $row->unit_price = $request->pro_price;
                $row->exp_date = $request->exp_date;

                $row->save();

            } else {
                $pro_temp_add = new ProductTemporary;
                $pro_temp_add->user_id = Auth::user()->id;
                $pro_temp_add->pro_id = $product->id;
                $pro_temp_add->pro_name = $product->pro_name;
                $pro_temp_add->type_name = ProductDetail::get_type_name($product->id);
                $pro_temp_add->short_qty = $shortQty;
                $pro_temp_add->qty = $request->pro_qty;
                $pro_temp_add->short_remarks = $request->remarks;
                $pro_temp_add->unit_price = $request->pro_price;
                $pro_temp_add->exp_date = $request->exp_date;
                $pro_temp_add->slno = '';
                $pro_temp_add->deal_type = '1';//1=purchase,2=sale
                $pro_temp_add->status = 1;

                $pro_temp_add->save();
            }

        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function getCartContent(){
        ProductTemporary::where('type',2)
                                ->where('slno','')
                                ->delete();
        $cart_content = ProductTemporary::where('user_id', Auth::user()->id)
        ->where('deal_type',1)
        ->get();

        return view('inventory.product-inventory.purchase.ajax.get-cart-content', compact('cart_content'));
    }

    public function updatecart(Request $request){
        $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->content_id)
                ->where('deal_type',1)
                ->get();
        $row->qty = $request->pro_qty;
        $row->save();
    }

    public function removecart(Request $request){
        ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->content_id)
                ->where('deal_type',1)
                ->delete();
    }

    public function addToCartWarrentyProduct(Request $request)
    {
        $product = ProductDetail::where('id', $request->pro_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('status', 1)
            ->where('pro_warranty', '!=', 0)
            ->first();
        
        $product_sl_no = array();
        if(!empty($product)) {
            
            $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->pro_id)
                ->where('deal_type',1)
                ->first();
            if(!empty($row)) {
                $row->pro_name = $product->pro_name;
                $row->type_name = ProductDetail::get_type_name($product->id);
                $row->unit_price = $request->pro_price;
                $row->exp_date = $request->exp_date;

                $row->save();
                if($row->slno != '') {
                    $product_sl_no = explode(',', $row->slno);
                }

            } else {
                $pro_temp_add = new ProductTemporary;
                $pro_temp_add->user_id = Auth::user()->id;
                $pro_temp_add->pro_id = $product->id;
                $pro_temp_add->pro_name = $product->pro_name;
                $pro_temp_add->type_name = ProductDetail::get_type_name($product->id);
                $pro_temp_add->qty = 0;
                $pro_temp_add->unit_price = $request->pro_price;
                $pro_temp_add->exp_date = $request->exp_date;
                $pro_temp_add->slno = '';
                $pro_temp_add->deal_type = '1';//1=purchase,2=sale
                $pro_temp_add->status = 1;
                $pro_temp_add->type = 2; //1=non-warranty , 2= warranty

                
                $pro_temp_add->save();
                

            }
            
        } else {
            return response()->json(['status' => 404]);
        }

        return view('inventory.product-inventory.purchase.ajax.warranty-product-get-sl-no-inner-form', compact('product', 'product_sl_no'));
    }

    public function addWarrentyProductSlNo(Request $request){
        // dd($request->all());
        $com = Auth::user()->company_id;
        $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->pro_id)
                ->where('deal_type',1)
                ->first();
        // dd($row);
        if(($request->sl_no == null) || ($request->sl_no == '')) {
            return false;
        }
        if(!empty($row)) {
            
            if($row->slno == '') {
                $pre_sl_no = array();
            } else {
                $pre_sl_no = explode(',',$row->slno);
            }
            if(in_array($request->sl_no, $pre_sl_no)) {
                return response()->json(['status' => 402]);//already added
            } 
            $pro_all_sl_no = $pre_sl_no;
            $pro_all_sl_no[] = $request->sl_no;
            $content_quantity = count($pro_all_sl_no);
            
            $row->slno = implode(',', $pro_all_sl_no);
            $row->qty = $content_quantity;
            $row->save();
            

            $content = $row;
            // dd($content);

            return view("inventory.product-inventory.purchase.ajax.warranty-product-sl-no-list", compact('content'));
        } else {
            return response()->json(['status' => 406]); //sl no not found
        }
    }

    public function removeWarrentyProductSlNo(Request $request)
    {
        $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->pro_id)
                ->where('deal_type',1)
                ->first();
        if(!empty($row)) {
            $pro_all_sl_no = explode(',',$row->slno);
            
            if (($key = array_search($request->sl_no, $pro_all_sl_no)) !== false) {
                unset($pro_all_sl_no[$key]);
            }
            $content_quantity = count($pro_all_sl_no);
            $row->slno = implode(',', $pro_all_sl_no);
            $row->qty = $content_quantity;
            $row->save();

            $content = $row;

            return view("inventory.product-inventory.purchase.ajax.warranty-product-sl-no-list", compact('content'));
        } else {
            return response()->json(['status' => 406]); //sl no not found
        }
    }

    public function invTemporaryBuy(Request $request){
        $user = Auth::user()->id;
        $com = Auth::user()->company_id;
        $request->validate([
            'supplier' => 'required',
            'memo' => 'required',
            'issue_date' => 'required'
        ],[
            'supplier.required' => 'Supplier is required',
            'memo.required' => 'Memo is required',
            'issue_date.required' => 'Issue Date is required',
        ]);
        $pro_temps = ProductTemporary::with('pro_warranty','sold_by')->where('user_id', $user)
                                            ->where('deal_type',1)
                                            ->get();
        $invoice = $request->memo;
        // dd($invoice);
        $pro_sup = Supplier::where('company_id', $com)
            ->where('id', $request->supplier)
            ->first();
        return view('inventory.product-inventory.purchase.buy-invoice',compact('pro_temps','pro_sup','invoice'));
    }

    public function cartSubmit(Request $request){
        ;
        $request->validate([
            'supplier' => 'required',
            'memo' => 'required',
            'issue_date' => 'required'
        ]);
        
        DB::beginTransaction();
        try {
            $com = Auth::user()->company_id;
            $user_id = Auth::user()->id;
            
            // start check memo no unique
            $check_memo = ProductInventory::where('company_id', $com)
                ->where('invoice_no', $request->memo)
                ->first();
            if(!empty($check_memo)) {
                session()->flash('type', 'warning');
                session()->flash('message', 'Duplicate memo no');
                return redirect()->back();
            }
            // dd('a');
            // end check memo no unique
            $cart_content = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('deal_type',1)
                ->get();
            
            $new_memo_no = $request->memo;
            

            // insert in product inventory table
            $total_purchase_amount = 0;
            
            foreach ($cart_content as $content) {
                $product_id = $content->pro_id;

                $check_product = ProductDetail::where('id', $product_id)
                    ->where('company_id', $com)
                    ->where('status', 1)
                    ->first();


                $req_sl_ids = explode(',', $content->slno);
                $k = 0;
                $new_req_sl_ids = array();
                foreach ($req_sl_ids as $sl_id) {
                    if($sl_id == '') {
                        unset($req_sl_ids[$k]);
                    } else {
                        $new_req_sl_ids[] = $req_sl_ids[$k];
                    }
                    $k++;
                }
                
                if($check_product->pro_warranty == 0) {
                    $req_qty = $content->qty;

                } else {
                    if (!isset($new_req_sl_ids)) {
                        $new_req_sl_ids = array();
                    }
                    $req_sl_ids = $new_req_sl_ids;
                    $req_qty = count($req_sl_ids);
                }



                
                $product_price = $content->unit_price;
                $sub_total = $req_qty * $product_price;
                $total_purchase_amount += $sub_total;
                $exp_date = $content->exp_date;
                $available_quantity = $req_qty - $content->short_qty;

                

                $product_inventory = new ProductInventory();
                $product_inventory->company_id = $com;
                $product_inventory->prodet_id = $product_id;
                $product_inventory->party_id = $request->supplier;
                $product_inventory->invoice_no = $new_memo_no;
                $product_inventory->total_qty = $req_qty;
                $product_inventory->short_qty = $content->short_qty;
                $product_inventory->short_remarks = $content->short_remarks;
                $product_inventory->qty = $available_quantity;
                $product_inventory->unit_price = $product_price;
                $product_inventory->debit = $sub_total;
                $product_inventory->credit = 0;
                $product_inventory->issue_date = Carbon::now();
                $product_inventory->exp_date = $exp_date;
                $product_inventory->tran_desc = "Purchase Product";
                $product_inventory->deal_type =  1;//1=supplier
                $product_inventory->tran_type =  1;//1=buy/sell product-buy
                $product_inventory->status = 1;
                $product_inventory->entry_by = $user_id;
                $product_inventory->updated_by = $user_id;

                $product_inventory->save();

                for ($i=0; $i < $req_qty; $i++) { 
                    
                    if($check_product->pro_warranty == 0) {

                    } else {
                        
                        // add warrenty product details in inv_product_inventory_details table
                        $pro_inv_details = new ProductInventoryDetail();
                        $pro_inv_details->com_id = $com;
                        $pro_inv_details->proinv_id = $product_inventory->id;
                        $pro_inv_details->pro_id = $check_product->id;
                        $pro_inv_details->buy_id = $request->supplier;
                        $pro_inv_details->slno = $req_sl_ids[$i];
                        $pro_inv_details->sell_status = 0;
                        $pro_inv_details->status = 1;
                        $pro_inv_details->entry_by = $user_id;
                        $pro_inv_details->updated_by = $user_id;
                        $pro_inv_details->save();
                        
                    }
                }

                
                $pro_sup = Supplier::where('company_id', $com)
                ->where('id', $request->supplier)
                ->first();

                
                // available quantity update in product detail table
                $after_submit_pro_available_quantity = $check_product->available_qty + $available_quantity;
                $check_product->available_qty = $after_submit_pro_available_quantity;

                $check_product->save();
            }

                

            ProductTemporary::where('user_id', Auth::user()->id)
                ->where('deal_type',1)
                ->delete();
            
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong to sell product. error-code: 1010'.$e->getMessage());
            return redirect()->back();
        }

        DB::commit();
        session()->flash('type', 'success');
        session()->flash('message', 'Buy Products Successfully completed');
        return redirect()->route('inventory.product-inventory.purchase.add-product');
    }
}
