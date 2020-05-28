<?php

namespace App\Models;
use App\Traits\UploadTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class VisaCounsellor extends Authenticatable implements JWTSubject
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'email', 'country', 'company', 'phonenumber',
        'whatsapp_number', 'gender', 'password', 'specialise_countries', 'countries_level',
        'qualification_date_from', 'qualification_date_to', 'qualification_description',
        'speak_languages', 'totalFee','profile_title', 'profile_overview', 'profile_image', 'phone_verification_number', 'phone_verified_at'
    ];
    protected $casts = [
        'specialise_countries'=>'array',
        'speak_languages'=>'array'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
