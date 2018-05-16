<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_role';

    /**
     * @var string
     */
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable;

    public function __construct ()
    {
        $this->fillable = self::getPermissions();
    }

    /**
     * @return array
     */
    public static function getPermissions ()
    {
        return [
            'productsShow',
            'productsAdd',
            'productsEdit',
            'productsDelete',
            'blogPostAdd',
            'blogPostEdit',
            'blogPostDelete',
            'usersShow',
            'usersEdit',
            'usersDelete',
            'usersAdd'
        ];
    }
}
