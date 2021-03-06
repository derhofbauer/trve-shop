<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_comment';

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
        'product_id',
        'content'
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
