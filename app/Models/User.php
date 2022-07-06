<?php

namespace App\Models;

use App\Notifications\VerifyEmail as VerifyEmailNotification;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_type',
        'phone_number',
        'is_superuser',
        'is_staff',
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
  /**
    * send the password reset notification.
    *
    * @param string $token
    * @return void
    */
   public function sendPasswordResetNotification($token)
   {
    $this->notify(new ResetPasswordNotification($token));
   }


/**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function isSuperUser()
    {
        return $this->is_superuser;
    }

    public function isStaffUser()
    {
        return $this->is_staff;
    }


    public function activeCode()
    {
        return $this->hasMany(ActiveCode::class);
    }


 public function hasTwoFactor($key)
 {
     return $this->two_factor_type == $key;
 }

 public function hasTwoFactorAuthenticatedEnabled()
 {
    return $this->two_factor_type !== 'off';
 }

 public function hasSmsTwoFactorAuthenticationEnabled() 
 {
    return $this->two_factor_type !== 'sms';
 }
}