<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use HasFactory;
    protected $table = 'product_groups';
    protected $fillable = 
    [
        'company_id',
        'name',
        'status',
        'entry_by',
        'updated_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function entryBy(){
        return $this->belongsTo('App\Models\User','entry_by','id');
    }

    public function updateBy(){
        return $this->belongsTo('App\Models\User','updated_by','id');
    }
}
