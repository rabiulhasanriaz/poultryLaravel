<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\ProductGroup;
use App\Models\ProductDetail;
use App\Models\ProductTemporary;
use App\Models\ProductType;
use App\Models\ProductInventoryDetail;
use App\Models\ProductInventory;
use App\Models\Project;

class ProductSellController extends Controller
{
    public function sellProduct(Request $request){
        $com = Auth::user()->company_id;
        
        $customers = Customer::where('company_id',$com)
                                  ->where('cus_status',1)
                                  ->get();

        $groups = ProductGroup::where('company_id',$com)
                                    ->where('status',1)
                                    ->get();
        // $employees = User::where('au_company_id',$com)
        //                        ->whereIn('au_user_type',[5,6])
        //                        ->get();
                            //    dd($employees);

        if ($request->has('searchbtn')) {
            $sell_pro = ProductDetail::where('company_id',$com)
                                        ->where('type_id',$request->type)
                                        ->where('status',1)
                                        ->get();
        }else{
            $sell_pro = ProductDetail::where('company_id',$com)
                                    ->where('status',1)
                                    ->get();
        }

        $cart_content = ProductTemporary::where('user_id', Auth::user()->id)
            ->whereIn('deal_type',[2,5])
            ->orderBy('deal_type','asc')
            ->get();
            $total = 0;
            $amount = 0;
            foreach ($cart_content as $content) {
                $amount = $content->unit_price * $content->qty; 
            }
            $total += $amount;
        return view('inventory.product-inventory.sell',compact('customers','groups','total','sell_pro'));
    }
    public function show_project_ajax(Request $request) {
        $com = Auth::user()->company_id;
        $projects = Project::where('company_id',$com)->where('customer', $request->cus_id)
                                ->where('status',1)
                                ->get();
        return view('inventory.product-inventory.ajax.project-ajax', compact('projects'));
    }
    public function show_pro_type_ajax(Request $request) {
        $types = ProductType::where('group_id', $request->grp_id)
                                ->where('status',1)
                                ->get();
        return view('inventory.product-inventory.ajax.sell-product-model-ajax', compact('types'));
    }
    public function product_search_ajax(Request $request){
        // dd($request->all());
        $com = Auth::user()->company_id;
        // return request()->all();
        $sell_product = ProductDetail::where('company_id',$com)
                                          ->where('type_id',$request->type_id)
                                          ->where('status',1)
                                          ->get();
                                        //   dd($sell_product);
        return view('inventory.product-inventory.ajax.product-search-sell-ajax',compact('sell_product'));

    }

    public function addToCart(Request $request)
    {
        // dd($request->all());
        $product = ProductDetail::where('id', $request->pro_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('status', 1)
            ->first();
        
        if(!empty($product)) {

            if($product->available_qty < $request->pro_qty) {
                return response()->json(['status' => 400]);
            }
            
            $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->pro_id)
                ->where('deal_type',2)
                ->first();
            if(!empty($row)) {
                $row->pro_name = $product->pro_name;
                $row->type_name = ProductDetail::get_type_name($product->id);
                $row->qty = $request->pro_qty;
                $row->unit_price = $request->pro_price;
                $row->exp_date = $request->exp_date;

                $row->save();

            } else {
                $pro_temp_add = new ProductTemporary;
                $pro_temp_add->user_id = Auth::user()->id;
                $pro_temp_add->pro_id = $product->id;
                $pro_temp_add->pro_name = $product->pro_name;
                $pro_temp_add->type_name = ProductDetail::get_type_name($product->id);
                $pro_temp_add->qty = $request->pro_qty;
                $pro_temp_add->unit_price = $request->pro_price;
                $pro_temp_add->exp_date = $request->exp_date;
                $pro_temp_add->slno = '';
                $pro_temp_add->deal_type = '2';//1=purchase,2=sale
                $pro_temp_add->status = 1;
                // dd($pro_temp_add);
                $pro_temp_add->save();
            }

        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function addServiceCharges(Request $request){
            $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', '')
                ->where('deal_type',5)
                ->first();
            if(!empty($row)) {
                $row->pro_name = 'Sell Service Charge';
                $row->type_name = 'Sell Service Charge';
                $row->qty = $request->qty;
                $row->unit_price = $request->service;

                $row->save();

            } else {
                $pro_temp_add = new ProductTemporary;
                $pro_temp_add->user_id = Auth::user()->id;
                $pro_temp_add->pro_name = 'Sell Service Charge';
                $pro_temp_add->type_name = 'Sell Service Charge';
                $pro_temp_add->qty = $request->qty;
                $pro_temp_add->unit_price = $request->service;
                $pro_temp_add->slno = '';
                $pro_temp_add->deal_type = '5';//5=Sell Service Charge
                $pro_temp_add->status = 1;

                $pro_temp_add->save();
            }
    }

    public function getCartContent(){
        ProductTemporary::where('type',2)
                                ->where('slno','')
                                ->delete();
        $cart_content = ProductTemporary::where('user_id', Auth::user()->id)
        ->whereIn('deal_type',[2,5])
        ->orderBy('deal_type','asc')
        ->get();

        return view('inventory.product-inventory.ajax.get-cart-content', compact('cart_content'));
    }

    public function updatecart(Request $request){
        $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->content_id)
                ->where('deal_type',2)
                ->get();
        $row->qty = $request->pro_qty;
        $row->save();
    }

    public function removecart(Request $request){
        ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->content_id)
                ->whereIn('deal_type',[2,5])
                ->delete();
    }

    public function addToCartWarrentyProduct(Request $request){
        $product = ProductDetail::where('id', $request->pro_id)
        ->where('company_id', Auth::user()->company_id)
        ->where('status', 1)
        ->where('pro_warranty', '!=', 0)
        ->first();
        $product_exist_slno = ProductInventoryDetail::where('com_id',Auth::user()->company_id)
                                                    ->where('sell_id',NULL)
                                                    ->where('pro_id',$product->id)
                                                    ->where('sell_status',0)
                                                    ->get();
            // return $product->inv_pro_det_id;
            //     return $product_exist_slno;
    
        $product_sl_no = array();
        if(!empty($product)) {
            
            $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->pro_id)
                ->where('deal_type',2)
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
                $pro_temp_add->deal_type = '2';//1=purchase,2=sale
                $pro_temp_add->status = 1;
                $pro_temp_add->type = 2; //1=non-warranty , 2= warranty
                $pro_temp_add->save();
            }
            
        } else {
            return response()->json(['status' => 404]);
        }

        return view('inventory.product-inventory.ajax.warranty-product-get-sl-no-inner-form', compact('product', 'product_sl_no','product_exist_slno'));
    }

    public function addWarrentyProductSlNo(Request $request)
    {
        $com = Auth::user()->company_id;
        
        $row = ProductTemporary::where('user_id', Auth::user()->id)
            ->where('pro_id', $request->pro_id)
            ->where('deal_type',2)
            ->first();
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

            // all inventory id of requested product
            $all_inv_ids_of_this_product = ProductInventory::where('company_id', $com)
                            ->where('prodet_id', $request->pro_id)
                            ->where('deal_type', 1)
                            ->where('tran_type', 1)
                            ->pluck('id')
                            ->toArray();//deal_type=1=supplier, tran_type=1=buy-sale

            // search this sl no products
            $pro_inv_det = ProductInventoryDetail::where('com_id', $com)
                ->where('slno', '!=', null)
                ->where('sell_status', 0)
                ->whereIn('proinv_id', $all_inv_ids_of_this_product)
                ->where('slno', $request->sl_no)
                ->first();

            if(empty($pro_inv_det)) {
                return response()->json(['status' => 404]); //sl no not found
            }
            $pro_all_sl_no = $pre_sl_no;
            $pro_all_sl_no[] = $request->sl_no;
            $content_quantity = count($pro_all_sl_no);

            $row->slno = implode(',', $pro_all_sl_no);
            $row->qty = $content_quantity;
            $row->save();
            
            $content = $row;

            return view("inventory.product-inventory.ajax.warranty-product-sl-no-list", compact('content'));
        } else {
            return response()->json(['status' => 406]); //sl no not found
        }
    }

    public function removeWarrentyProductSlNo(Request $request)
    {
        $row = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('pro_id', $request->pro_id)
                ->where('deal_type',2)
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

            return view("inventory.product-inventory.ajax.warranty-product-sl-no-list", compact('content'));
        } else {
            return response()->json(['status' => 406]); //sl no not found
        }
    }

    public function invTemporaryProduct(Request $request){
        // dd($request->all());
        $user = Auth::user()->id;
        $com = Auth::user()->company_id;
        $request->validate([
            'customer' => 'required',
            'type' => 'required'
        ],[
            'customer.required' => 'Customer is required',
            'type.required' => 'Type is required',
        ]);
        $pro_temps = ProductTemporary::where('user_id', $user)
                                    ->whereIn('deal_type',[2,5])
                                    ->orderBy('deal_type','asc')
                                    ->get();
        // $service = $request->service;
        
        
                        // dd($emp);
        $delivery = $request->delivery;
        $discount = $request->discount;
        $project = $request->project;
        $pro_cus = Customer::where('company_id', $com)
            ->where('id', $request->customer)
            ->first();
        return view('inventory.product-inventory.sell-invoice',compact('project','pro_temps','pro_cus','delivery','discount'));
    }

    public function cartSubmit(Request $request){
        // dd(request()->all());
        $request->validate([
            'customer' => 'required'
        ]);
        
        DB::beginTransaction();
        try {
            $com = Auth::user()->company_id;
            $user_id = Auth::user()->id;
            $cart_content = ProductTemporary::where('user_id', Auth::user()->id)
                ->where('deal_type',2)
                ->get();
            
            $last_pro_inv = ProductInventory::where('company_id', $com)
                ->where('deal_type', 2)
                ->where('tran_type', 1)
                ->orderBy('id', 'DESC')
                ->first();
            if(!empty($last_pro_inv)) {
                $last_pro_inv_memo_no = $last_pro_inv->invoice_no;                
                $last_data = substr($last_pro_inv_memo_no, 13);
                if(is_numeric($last_data)) {
                    $last_number = $last_data + 1;
                    $last_number_length = strlen($last_number);
                    if ($last_number_length < 6) {
                        $less_number = 6-$last_number_length;
                        $sl_prefix = "";
                        for ($x=0; $x <$less_number ; $x++) { 
                            $sl_prefix = $sl_prefix . "0";
                        }
                        $last_number = $sl_prefix . $last_number;
                    }
                    
                    $new_memo_no = "INV".$com.date('Y').($last_number);
                } else {
                    $new_memo_no = "INV".$com.date('Y')."000001";
                }
            } else {
                $new_memo_no = "INV".$com.date('Y')."000001";
            }
            
            foreach ($cart_content as $content) {
                $product_id = $content->pro_id;
                $req_qty = $content->qty;

                $check_product = ProductDetail::where('id', $product_id)
                    ->where('company_id', $com)
                    ->where('status', 1)
                    ->where('available_qty', '>=', $req_qty)
                    ->first();

                if(empty($check_product)) {
                    DB::rollback();
                    $msg = "Invalid/Insufficient ". $content->pro_name ." Product. error-code: 1006";
                    return redirect()->back()->with(['sub_err' => $msg]);
                }
            }

            // insert in product inventory table
            $total_purchase_amount = 0;
            
            foreach ($cart_content as $content) {
                $product_id = $content->pro_id;
                $req_qty = $content->qty;
                $product_price = $content->unit_price;
                $sub_total = $req_qty * $product_price;
                $total_purchase_amount += $sub_total;

                $check_product = ProductDetail::where('id', $product_id)
                    ->where('company_id', $com)
                    ->where('status', 1)
                    ->first();

                if($check_product->pro_warranty == 0) {
                    $req_qty = $content->qty;
                }  else {
                    $req_sl_ids = explode(',', $content->slno);
                    $k = 0;
                    $new_req_sl_ids =array();
                    foreach ($req_sl_ids as $sl_id) {
                        if($sl_id == '') {
                            unset($req_sl_ids[$k]);
                        } else {
                            $new_req_sl_ids[] = $req_sl_ids[$k];
                        }
                        $k++;
                    }

                    if (!isset($new_req_sl_ids)) {
                        $new_req_sl_ids = array();
                    }
                    $req_sl_ids = $new_req_sl_ids;
                    $req_qty = count($req_sl_ids);
                }
                

                $product_inventory = new ProductInventory();
                $product_inventory->company_id = $com;
                $product_inventory->prodet_id = $content->pro_id;
                $product_inventory->project_id = $request->project;
                $product_inventory->party_id = $request->customer;
                $product_inventory->invoice_no = $new_memo_no;
                $product_inventory->qty = $req_qty;
                $product_inventory->unit_price = $product_price;
                $product_inventory->debit = $sub_total;
                $product_inventory->credit = 0;
                $product_inventory->issue_date = Carbon::now();
                $product_inventory->tran_desc = "Sell Product";
                $product_inventory->deal_type =  2;//2=customer
                $product_inventory->tran_type =  1;//1=buy/sell product-buy
                $product_inventory->status = 1;
                $product_inventory->entry_by = $user_id;
                $product_inventory->updated_by = $user_id;
                // dd($product_inventory);
                $product_inventory->save();
                

                for ($i=0; $i < $req_qty; $i++) { 
                    
                    if($check_product->pro_warranty == 0) {
                        
                    } else {
                        
                        
                        $request_sl_no = $req_sl_ids[$i];
                        if($request_sl_no == '') {
                            DB::rollback();
                            session()->flash('type', 'danger');
                            session()->flash('message', 'Something went wrong to sell product. product name: '. $content->pro_name .'. error-code: 1003');
                        }

                        // search and update previous product details sales_status 
                        $all_inv_ids_of_this_product = ProductInventory::where('company_id', $com)
                            ->where('prodet_id', $check_product->id)
                            ->where('deal_type', 1)
                            ->where('tran_type', 1)
                            ->pluck('id')
                            ->toArray();
                            
                        $pre_pro_inv_details = ProductInventoryDetail::where('com_id', $com)
                            ->whereIn('proinv_id', $all_inv_ids_of_this_product)
                            ->where('sell_status', 0)
                            ->where('slno', $request_sl_no)
                            ->first();
                        
                        if(!empty($pre_pro_inv_details)) {
                            $pre_pro_inv_details->sell_status = 1;
                            $pre_pro_inv_details->proinv_sell_id = $product_inventory->id;
                            $pre_pro_inv_details->sell_id = $request->customer;
                            
                            $pre_pro_inv_details->save();
                        } else {
                            // DB::rollback();
                            DB::rollback();
                            session()->flash('type', 'danger');
                            session()->flash('message', 'Something went wrong to sell product. product name: '. $content->name .'. error-code: 1002');
                            // $msg = "Something went wrong to sell product. product name: ". $content->name .". error-code: 1002";
                            // return redirect()->back()->with(['sub_err' => $msg]);
                        }
                        
                    }
                }

                
                // available quantity update in product detail table
                $after_submit_pro_available_quantity = $check_product->available_qty - $req_qty;
                $check_product->available_qty = $after_submit_pro_available_quantity;

                $check_product->save();


            }
            $service_charge_cart_content = ProductTemporary::where('user_id', Auth::user()->id)
            ->where('deal_type',5)
            ->first(); 
            if (!empty($service_charge_cart_content) > 0) {
                $product_inventory = new ProductInventory();
                $debit = $service_charge_cart_content->unit_price * $service_charge_cart_content->qty;
                $product_inventory->company_id = $com;
                $product_inventory->prodet_id = NULL;
                $product_inventory->project_id = $request->project;
                $product_inventory->party_id = $request->customer;
                $product_inventory->invoice_no = $new_memo_no;
                $product_inventory->qty = $service_charge_cart_content->qty;
                $product_inventory->unit_price = $service_charge_cart_content->unit_price;
                $product_inventory->debit = $debit;
                $product_inventory->credit = 0;
                $product_inventory->issue_date = Carbon::now();
                $product_inventory->tran_desc = "Setup/Service/Install Charges";
                $product_inventory->deal_type =  2;//2=customer
                $product_inventory->tran_type =  10;//10=serviceCharges,11=deliveryCharges
                $product_inventory->status = 1;
                $product_inventory->entry_by = $user_id;
                $product_inventory->updated_by = $user_id;

                $product_inventory->save();
            }
            if ($request->delivery > 0) {
                $product_inventory = new ProductInventory();
                $product_inventory->company_id = $com;
                $product_inventory->prodet_id = NULL;
                $product_inventory->party_id = $request->customer;
                $product_inventory->project_id = $request->project;
                $product_inventory->invoice_no = $new_memo_no;
                $product_inventory->qty = 0;
                $product_inventory->unit_price = $request->delivery;
                $product_inventory->debit = $request->delivery;
                $product_inventory->credit = 0;
                $product_inventory->issue_date = Carbon::now();
                $product_inventory->tran_desc = "Sell Product Delivery Charge";
                $product_inventory->deal_type =  2;//2=customer
                $product_inventory->tran_type =  11;//10=serviceCharges,11=deliveryCharges
                $product_inventory->status = 1;
                $product_inventory->entry_by = $user_id;
                $product_inventory->updated_by = $user_id;

                $product_inventory->save();
            }

            if ($request->discount > 0) {
                $product_inventory = new ProductInventory();
                $product_inventory->company_id = $com;
                $product_inventory->prodet_id = NULL;
                $product_inventory->party_id = $request->customer;
                $product_inventory->project_id = $request->project;
                $product_inventory->invoice_no = $new_memo_no;
                $product_inventory->qty = 0;
                $product_inventory->unit_price = $request->discount;
                $product_inventory->debit = 0;
                $product_inventory->credit = $request->discount;
                $product_inventory->issue_date = Carbon::now();
                $product_inventory->tran_desc = "Sell Product Discount";
                $product_inventory->deal_type =  2;//2=customer
                $product_inventory->tran_type =  12;//10=serviceCharges,11=deliveryCharges,12-discount
                $product_inventory->status = 1;
                $product_inventory->entry_by = $user_id;
                $product_inventory->updated_by = $user_id;

                $product_inventory->save();
            }

            
            ProductTemporary::where('user_id', Auth::user()->id)
                ->whereIn('deal_type',[2,5])
                ->delete();

            
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong to sell product. error-code: 1010'.$e->getMessage());
            return redirect()->back();
        }

        DB::commit();
        session()->flash('type', 'success');
        session()->flash('message', 'Sell Products Successfully completed');
        return redirect()->route('inventory.product-inventory.sale.sell-product');
    }

    public function sell_reports_pdf(Request $request,$invoice_r){
        // dd($request->all());
        $com = Auth::user()->company_id;

        $invoice_detail = ProductInventory::with('getCustomerInfo','getSoldByInfo')->where('company_id',$com)
                                        ->where('deal_type',2)
                                        ->where('tran_type',1)
                                        ->where('invoice_no',$invoice_r)
                                        ->first();

        $invoice = ProductInventory::where('company_id',$com)
                                        ->where('deal_type',2)
                                        ->whereIn('tran_type',[1,10])
                                        ->where('invoice_no',$invoice_r)
                                        ->orderBy('tran_type','asc')
                                        ->get();
                                        // dd($invoice);

        $services_delivery = ProductInventory::where('company_id',$com)
                                        ->where('deal_type',2)
                                        ->whereIn('tran_type',[11,12])
                                        ->where('invoice_no',$invoice_r)
                                        ->orderBy('tran_type','desc')
                                        ->get();
                                        // dump($invoice);
                                        // dd($services_delivery);
        
        if (isset($request->print)) {
            session()->flash('print_invoice',true);
            return view('inventory.reports.sell-print',compact('invoice','invoice_detail','services_delivery'));
        }elseif(isset($request->view)){
            return view('inventory.reports.sell_print',compact('invoice','invoice_detail','services_delivery'));
        }

        $pdf = PDF::loadView('inventory.reports.SellIndividualInvoicePdf',compact('invoice','invoice_detail'));
        return $pdf->download($invoice_detail->inv_pro_inv_invoice_no.'.pdf');
    }
}
