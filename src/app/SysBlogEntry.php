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

    public function author ()
    {
        return $this->belongsTo('App\SysBeUser', 'beuser_id');
    }

    public function beuser () {
        return $this->author();
    }
}
