<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysOrderProductMM
 *
 * @package App
 */
class SysOrderProductMM extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_order_product_mm';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_quantity'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order () {
        return $this->belongsTo('App\SysOrder','order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product () {
        return $this->belongsTo ('App\SysProduct', 'product_id');
    }
}
