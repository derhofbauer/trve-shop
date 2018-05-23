<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysRole
 *
 * @package App
 */
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

    /**
     * SysRole constructor.
     */
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
            'blogPostsShow',
            'blogPostsAdd',
            'blogPostsEdit',
            'blogPostsDelete',
            'beusersShow',
            'beusersEdit',
            'beusersDelete',
            'beusersAdd',
            'feusersShow',
            'feusersEdit',
            'feusersAdd',
            'feusersDelete'
        ];
    }
}
