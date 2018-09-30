<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Traits\Entities\EntityValidatorTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use EntityValidatorTrait, Notifiable, HasApiTokens;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [
    'password', 'remember_token',
  ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            self::normalizeUserData($model);
        });

        self::updating(function ($model) {
            self::normalizeUserData($model);
        });
    }
    private static function normalizeUserData(&$model)
    {
        $model['password'] = bcrypt($model['password']);
    }
}
