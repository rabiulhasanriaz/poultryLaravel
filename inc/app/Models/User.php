<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'company_id',
        'name',
        'contact_person',
        'phone',
        'email',
        'password',
        'rawp',
        'address',
        'logo'
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function company_logo($com_id){
        $logo = User::where('company_id',$com_id)
                          ->first();
        return $logo;
    }

    public static function company_info($com_id){
        $admin_query = User::where('user_type',2)
                                ->where('company_id',$com_id)
                                ->first();
        return $admin_query;
    }
}
