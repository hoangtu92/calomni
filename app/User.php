<?php

namespace App;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    use CrudTrait;

    //Account status
    const PENDING = "pending";
    const ACTIVATED = "activated";

    //Login status
    const ACTIVE = "active";
    const INACTIVE = "inactive";

    //Role
    const SH = "sh";
    const RH = "rh";
    const ADMIN = "admin";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', "uid", "role", "email_verified_at", "login_status", "activation_status", "last_token", "remember_token"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAdministrate(){
        return $this->role == self::ADMIN;
    }

    public function canRH(){
        return $this->role == self::RH;
    }

    public function canSH(){
        return $this->role == self::SH;
    }
}
