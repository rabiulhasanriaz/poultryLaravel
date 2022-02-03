<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTemporary extends Model
{
    use HasFactory;
    protected $table = 'product_temporaries';
    protected $fillable = 
    [
        'user_id',
        'cus_id',
        'pro_id',
        'project_id',
        'pro_name',
        'type_name',
        'short_qty',
        'short_remarks',
        'qty',
        'invoice_no',
        'unit_price',
        'exp_date',
        'slno',
        'deal_type',
        'status',
        'type'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function pro_warranty(){
        return $this->belongsTo('App\Models\ProductDetail','pro_id','id');
    }

    public function sold_by(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
