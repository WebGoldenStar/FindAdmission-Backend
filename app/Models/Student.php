<?php

namespace App\Models;
use App\Traits\UploadTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends Authenticatable implements JWTSubject
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'email', 'country', 'company', 'phonenumber',
        'whatsapp_number', 'gender', 'birthday', 'password', 'visa_country', 'visa_type',
        'is_travelled_country', 'travelled_country_detail', 'is_refused_country',
        'refused_country_detail', 'is_deported_country','deported_country_detail', 'personal_circumstances', 
        "sponsoring_education", "is_excluding_tuition", "excluding_tuition_detail", "is_received_admission", 
        "received_admission_detail", "study_course", "address", "state", 'profile_image'
    ];
    protected $casts = [
        'visa_country'=>'array',
        'personal_circumstances'=>'array',
        'sponsoring_education'=>'array'
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
