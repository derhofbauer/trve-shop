<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysBlogEntry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_blog_entry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'abstract',
        'content',
        'beuser_id'
    ];
}
