<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\ProductInventory;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = 
    [
        'company_id',
        'company_name',
        'address',
        'person',
        'mobile',
        'phone',
        'email',
        'website',
        'complain_number',
        'due_balance',
        'balance_type',
        'type',
        'status',
        'entry_by',
        'update_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public static function getNewSupplierMemoNo() {
        $company_id = Auth::user()->au_company_id;
        $last_pro_inv = ProductInventory::where('company_id', $company_id)
            ->where('deal_type', 1)
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
                
                
                $new_memo_no = "INVPS".$company_id.date('Y').($last_number);
            } else {
                $new_memo_no = "INVPS".$company_id.date('Y')."000001";
            }
        } else {
            $new_memo_no = "INVPS".$company_id.date('Y')."000001";
        }

        return $new_memo_no;
    }
}
