<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Agent extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard_name = 'sanctum';

    protected $fillable = [
        'name',
        'email',
        'password',
        'enc_pass',
        'agent_id',
        'user_id',
        'user_type',
        'father_name'       ,
        'mother_name'       ,
        'email'             ,
        'password'          ,
        'mobile'            ,
        'whatsapp_number'   ,
        'dob'               ,
        'country'           ,
        'state'             ,
        'city'              ,
        'home_address'      ,
        'current_address'   ,
        'pan_number'        ,
        'pan_image'         ,
        'bank_account'      ,
        'ifcs_code'         ,
        'branch'            ,
        'bank_holder_name'  ,
        'upi_number'        ,
        'adhar_number'      ,
        'profile_image'     ,
        'signature_image'   ,
    ];

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
}
