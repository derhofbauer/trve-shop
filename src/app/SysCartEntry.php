<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysCartEntry
 *
 * @package App
 */
class SysCartEntry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_cart_entry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feuser_id',
        'product_id',
        'product_quantity'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feuser ()
    {
        return $this->belongsTo('App\SysFeuser', 'feuser_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user ()
    {
        return $this->feuser();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product ()
    {
        return $this->belongsTo('App\SysProduct', 'product_id');
    }
}
