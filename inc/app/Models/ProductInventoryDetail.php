<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventoryDetail extends Model
{
    use HasFactory;
    protected $table = 'product_inventory_details';
    protected $fillable = 
    [
        'com_id',
        'proinv_id',
        'proinv_sell_id',
        'pro_id',
        'buy_id',
        'sell_id',
        'slno',
        'sell_status',
        'status',
        'entry_by',
        'updated_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
}
