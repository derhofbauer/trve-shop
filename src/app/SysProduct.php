<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class SysProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_product';

    /**
     * @var string
     */
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'hidden',
        'deleted',
        'media',
        'parent_product_id',
        'new_until'
    ];

    public function parent ()
    {
        return $this->belongsTo('App\SysProduct', 'parent_product_id', 'id');
    }

    public function children ()
    {
        return $this->hasMany('App\SysProduct', 'parent_product_id', 'id');
    }

    public static function allWithoutDeleted ()
    {
        return SysProduct::where('deleted', 0);
    }
}
