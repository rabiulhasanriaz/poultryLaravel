<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $table = 'product_types';
    protected $fillable =
    [
        'company_id',
        'group_id',
        'name',
        'status',
        'entry_by',
        'updated_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function groupName(){
        return $this->belongsTo('App\Models\ProductGroup','group_id','id');
    }
}
