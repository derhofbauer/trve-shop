<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysAddress
 *
 * @package App
 */
class SysAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_address';

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
        'country',
        'city',
        'zip',
        'street',
        'street_number',
        'address_line_2',
        'feuser_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feuser ()
    {
        return $this->belongsTo('App\SysFeuser', 'feuser_id');
    }
}
