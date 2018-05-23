<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

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
        'parent_product_id',
        'new_until'
    ];

    protected $casts = [
        'media' => 'array'
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

    public function addMedia ($file)
    {
        $tmp = $this->media;
        $tmp[] = $file;
        $this->media = $tmp;
    }

    public function removeMedia ($file)
    {
        $tmp = $this->media;
        $index = array_search($file, $tmp);
        unset($tmp[$index]);
        $this->media = $tmp;

        Storage::disk('local')->delete($file);
    }
}
