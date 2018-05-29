<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysPaymentMethod
 *
 * @package App
 */
class SysPaymentMethod extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_payment_method';

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
        'feuser_id',
        'data'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feuser ()
    {
        return $this->belongsTo('App\SysFeuser', 'feuser_id');
    }
}
