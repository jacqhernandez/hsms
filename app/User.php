<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Auth;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'role', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function isGeneralManager()
    {
        if($this->attributes['role'] == 'General Manager')
        {
            return true;
        }
        elseif (Auth::guest())
        {
            return false;
        }
        else
        {
            return false;
        }
    }

    public function isAccounting()
    {
        if($this->attributes['role'] == 'Accounting')
        {
            return true;
        }
        elseif (Auth::guest())
        {
            return false;
        }
        else
        {
            return false;
        }
    }

    public function isSales()
    {
        if($this->attributes['role'] == 'Sales')
        {
            return true;
        }
        elseif (Auth::guest())
        {
            return false;
        }
        else
        {
            return false;
        }
    }

    public function Clients()
    {
        return $this->hasMany('App\Client');
    }
}
