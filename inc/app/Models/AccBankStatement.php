<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class AccBankStatement extends Model
{
    use HasFactory;
    protected $table = 'acc_bank_statements';
    protected $fillable = 
    [
        'company_id',
        'inventory_id',
        'reference_id',
        'reference_type',
        'bank_id',
        'debit',
        'credit',
        'transaction_date',
        'voucher_no',
        'description',
        'contra_transaction_id',
        'status',
        'entry_by',
        'updated_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public static function getTotalCreditByBankId($bankId)
    {
        $credit = DB::table('acc_bank_statements')
                   ->select(DB::raw('SUM(credit) as total'))
                   ->where('status',1)
                   ->where('bank_id',$bankId)
                   ->where('company_id',Auth::user()->company_id)
                   ->get();
        foreach ($credit as $value) {
            return $value->total;
        }
    }
    public static function getTotalDebitByBankId($bankId)
    {
        $debit = DB::table('acc_bank_statements')
                   ->select(DB::raw('SUM(debit) as total'))
                   ->where('status',1)
                   ->where('bank_id',$bankId)
                   ->where('company_id',Auth::user()->company_id)
                   ->get();
        foreach ($debit as $value) {
            return $value->total;
        }
    }
    public static function getAvailableBalanceByBankId($bankId)
    {
        $availableBalance = DB::table('acc_bank_statements')
                              ->select(DB::raw('SUM(credit - debit) as total'))
                              ->where('status',1)
                              ->where('bank_id',$bankId)
                              ->where('company_id',Auth::user()->company_id)
                              ->get();
        foreach ($availableBalance as $value) {
            return $value->total;
        }
    }

    
}
