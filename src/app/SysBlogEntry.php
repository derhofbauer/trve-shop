<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysBlogEntry
 *
 * @package App
 */
class SysBlogEntry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_blog_entry';

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
        'title',
        'abstract',
        'content',
        'beuser_id',
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author ()
    {
        return $this->belongsTo('App\SysBeUser', 'beuser_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function beuser ()
    {
        return $this->author();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products ()
    {
        return $this->belongsToMany('App\SysProduct', 'sys_blog_product_mm', 'blog_entry_id', 'product_id');
    }
}
