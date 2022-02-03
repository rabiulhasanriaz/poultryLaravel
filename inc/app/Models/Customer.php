<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\ProductInventory;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = 
    [
        'company_id',
        'cus_name',
        'cus_com_name',
        'cus_mobile',
        'cus_email',
        'cus_address',
        'cus_website',
        'cus_type',
        'cus_customer_type',
        'cus_status',
        'entry_by',
        'updated_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public static function getNewCustomerMemoNo() {
        $com = Auth::user()->company_id;

        $last_pro_inv = ProductInventory::where('company_id', $com)
            ->where('deal_type', 2)
            ->where('tran_type', 3)
            ->orderBy('id', 'DESC')
            ->first();
        if(!empty($last_pro_inv)) {
            $last_pro_inv_memo_no = $last_pro_inv->inv_pro_inv_invoice_no;                
            $last_data = substr($last_pro_inv_memo_no, 15);
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
                
                $new_memo_no = "INVPC".$com.date('Y').($last_number);
            } else {
                $new_memo_no = "INVPC".$com.date('Y')."000001";
            }
        } else {
            $new_memo_no = "INVPC".$com.date('Y')."000001";
        }

        return $new_memo_no;
    }
}
