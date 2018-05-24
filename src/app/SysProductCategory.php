<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysProductCategory
 *
 * @package App
 */
class SysProductCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_product_category';

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
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'media' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products ()
    {
        return $this->belongsToMany('App\SysProduct', 'sys_product_category_mm', 'category_id', 'product_id');
    }

    /**
     * @param string $path
     */
    public function addMedia ($path)
    {
        $tmp = $this->media;
        $tmp[] = $path;
        $this->media = $tmp;
    }

    /**
     * @param string $path
     */
    public function removeMedia ($path)
    {
        $tmp = $this->media;
        $index = array_search($path, $tmp);
        unset($tmp[$index]);
        $this->media = $tmp;

        Storage::disk('local')->delete($path);
    }
}
