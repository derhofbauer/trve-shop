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
        $permissions = [];
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('products'));
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('categories'));
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('comments'));
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('ratings'));
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('blogPosts'));
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('beusers'));
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('feusers'));
        $permissions = array_merge($permissions, self::prepareCRUDpermissions('orders'));

        return $permissions;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public static function prepareCRUDpermissions ($key)
    {
        return [
            "{$key}Show",
            "{$key}Add",
            "{$key}Edit",
            "{$key}Delete",
        ];
    }
}
