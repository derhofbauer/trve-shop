<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * Class SysFeuser
 *
 * @package App
 */
class SysFeuser extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'title',
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
     * @param string $password
     */
    public function setPassword ($password)
    {
        $this->password = Hash::make($password);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartEntries ()
    {
        return $this->hasMany('App\SysCartEntry', 'feuser_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart ()
    {
        return $this->cartEntries();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders ()
    {
        return $this->hasMany('App\SysOrder', 'feuser_id')->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses ()
    {
        return $this->hasMany('App\SysAddress', 'feuser_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods ()
    {
        return $this->hasMany('App\SysPaymentMethod', 'feuser_id');
    }
}
