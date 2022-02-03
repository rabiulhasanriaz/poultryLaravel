<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = 
    [
        'company_id',
        'name',
        'customer',
        'issue_date',
        'status',
        'entry_by',
        'update_by'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function customerInfo(){
        return $this->belongsTo('App\Models\Customer','customer','id');
    }

    public static function totalProject(){
        $com = Auth::user()->company_id;
        $project = DB::table('projects')
                ->select(DB::raw('count(id) as totalProject'))
                ->where('company_id',$com)
                ->get();
        foreach ($project as  $value) {
            return $value->totalProject;
        }
    }
}
