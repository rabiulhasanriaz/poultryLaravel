<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'product_details';
    protected $fillable = 
    [
        'company_id',
        'type_id',
        'supplier',
        'pro_name',
        'buy_price',
        'sell_price',
        'pro_warranty',
        'pro_description',
        'available_qty',
        'short_qty',
        'status',
        'entry_by',
        'updated_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function typeName(){
        return $this->belongsTo('App\Models\ProductType','type_id','id');
    }

    public static function get_type_name($pro_id)
    {
        $product = ProductDetail::where('id', $pro_id)->first();
        if(!empty($product)) {
            return ProductType::select('name')->where('id', $product->type_id)->first()->name;
        }
        return '';
    }
}
