<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class ProductInventory extends Model
{
    use HasFactory;
    protected $table = 'product_inventories';
    protected $fillable = 
    [
        'company_id',
        'party_id',
        'exp_id',
        'prodet_id',
        'project_id',
        'invoice_no',
        'total_qty',
        'short_qty',
        'short_remarks',
        'qty',
        'unit_price',
        'debit',
        'credit',
        'issue_date',
        'barcode',
        'exp_date',
        'tran_desc',
        'deal_type',
        'tran_type',
        'confirm',
        'sell_ref',
        'status',
        'edit_count',
        'damage_status',
        'entry_by',
        'updated_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public static function getSupCreditByID($party_id){
        $credit = DB::table('product_inventories')
                    ->select(DB::raw('SUM(credit) as total'))
                    ->where('party_id', $party_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('status', 1)
                    ->where('deal_type', 1)
                    ->get();
        foreach ($credit as $value) {
           return $value->total;
        }
    }
    public static function getSupDebitByID($party_id){
        $debit = DB::table('product_inventories')
                    ->select(DB::raw('SUM(debit) as total'))
                    ->where('party_id', $party_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('status', 1)
                    ->where('deal_type', 1)
                    ->get();
        foreach ($debit as $value) {
            return $value->total;
        }
    }

    public static function getSupBalanceByID($party_id)
    {
        $balance = DB::table('product_inventories')
                    ->select(DB::raw('SUM(credit - debit) as total'))
                    ->where('party_id', $party_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('status', 1)
                    ->where('deal_type', 1)
                    ->get();
        foreach ($balance as $value) {
            return $value->total;
        }
    }

    public static function getCusDebitByID($party_id)
    {
        $debit = DB::table('product_inventories')
                    ->select(DB::raw('SUM(debit) as total'))
                    ->where('party_id', $party_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('status', 1)
                    ->where('deal_type', 2)
                    ->get();
        foreach ($debit as $value) {
            return $value->total;
        }
    }

    public static function getCusCreditByID($party_id)
    {
        $credit = DB::table('product_inventories')
                    ->select(DB::raw('SUM(credit) as total'))
                    ->where('party_id', $party_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('status', 1)
                    ->where('deal_type', 2)
                    ->get();
        foreach ($credit as $value) {
            return $value->total;
        }
    }

    public static function getCusBalanceByID($party_id)
    {
        $balance = DB::table('product_inventories')
                    ->select(DB::raw('SUM(credit - debit) as total'))
                    ->where('party_id', $party_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('status', 1)
                    ->where('deal_type', 2)
                    ->get();
        foreach ($balance as $value) {
            return $value->total;
        }
    }

    public function getCustomerInfo(){
        return $this->belongsTo('App\Models\Customer','party_id','id');
    }

    public function getSoldByInfo(){
        return $this->belongsTo('App\Models\User','entry_by','id');
    }

    public static function ProductSerialSell($pro_inv_id){
        return ProductInventoryDetail::where('proinv_sell_id', $pro_inv_id)
        ->pluck('slno')
        ->toArray();
    }

    public static function getInvoice($partyID){
        $com = Auth::user()->company_id;
        return $invoice = ProductInventory::where('company_id',$com)
                                               ->where('party_id',$partyID)
                                               ->first();
    }

    public function getProductWarranty(){
        return $this->belongsTo('App\Models\ProductDetail','prodet_id','id');
    }
    

    public static function getTotalDebit($invoiceId){
        $com = Auth::user()->company_id;
        $total = DB::table('product_inventories')
                    ->select(DB::raw('SUM(debit) as total'))
                    ->where('invoice_no', $invoiceId)
                    ->where('company_id', $com)
                    ->get();

            foreach ($total as $value) {
                return $value->total;
            }
    }

    public static function get_discount_amount($inv_id){
        $discount = ProductInventory::where('invoice_no',$inv_id)
                                    ->where('deal_type',2)
                                    ->where('tran_type',12)
                                    ->first();
        if (!empty($discount)) {
            $discount_amount = $discount->credit;
        }else {
            $discount_amount = 0;
        }
        return $discount_amount;
    }

    public function getSupplierInfo(){
        return $this->belongsTo('App\Models\Supplier','party_id','id');
    }

    public static function totalInvoices($invoice){
        $com = Auth::user()->company_id;
        $invoices = DB::table('product_inventories')
                    ->select(DB::raw('count(*) as total'))
                    ->where('project_id', $invoice)
                    ->where('company_id', $com)
                    ->get();
        foreach ($invoices as $value) {
            return $value->total;
        }
    }

    public function projectAmount($projectId){
        $com = Auth::user()->company_id;
        $projectAmount = DB::table('product_inventories')
                        ->select(DB::raw('SUM(debit-credit) as totalAmount'))
                        ->where('company_id',$com)
                        ->where('project_id',$projectId)
                        ->where('deal_type',2)
                        ->whereIn('tran_type',[1,4,10,11,12])
                        
                        ->get();
        foreach ($projectAmount as $value) {
            return $value->totalAmount;
        }
    }
}
