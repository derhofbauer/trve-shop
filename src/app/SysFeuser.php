<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

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

    public function setPassword ($password)
    {
        $this->password = Hash::make($password);
    }
}
