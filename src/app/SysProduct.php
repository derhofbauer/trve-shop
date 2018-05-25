<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class SysProduct
 *
 * @package App
 */
class SysProduct extends Model
{
    use SoftDeletes;

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
        'parent_product_id',
        'new_until'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent ()
    {
        return $this->belongsTo('App\SysProduct', 'parent_product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children ()
    {
        return $this->hasMany('App\SysProduct', 'parent_product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories ()
    {
        return $this->belongsToMany('App\SysProductCategory', 'sys_product_category_mm', 'product_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordersMM ()
    {
        return $this->hasMany('App\SysOrderProductMM', 'product_id');
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

    /**
     * @param SysProductCategory $category
     */
    public function addCategory (SysProductCategory $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories()->attach($category);
        }
    }

    /**
     * @param SysProductCategory $category
     */
    public function removeCategory (SysProductCategory $category)
    {
        if ($this->categories->contains($category)) {
            $this->categories()->detach($category);
        }
    }
}
