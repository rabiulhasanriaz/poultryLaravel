<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccBankInfo extends Model
{
    use HasFactory;
    protected $table = 'acc_bank_infos';
    protected $fillable = 
    [
        'company_id',
        'bank_id',
        'branch_name',
        'account_name',
        'account_no',
        'open_date',
        'account_type',
        'status',
        'entry_by',
        'updated_by',
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function bank_info(){
    	return $this->belongsTo('App\Models\Bank', 'bank_id', 'id');
    }
}
