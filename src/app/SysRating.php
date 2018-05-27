<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysRating extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_rating';

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
        'feuser_id',
        'product_id',
        'rating'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author ()
    {
        return $this->belongsTo('App\SysFeuser', 'feuser_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feuser ()
    {
        return $this->author();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product ()
    {
        return $this->belongsTo('App\SysProduct', 'product_id');
    }
}
