<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartEntries ()
    {
        return $this->hasMany('App\SysCartEntry', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments ()
    {
        return $this->hasMany('App\SysComment', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings ()
    {
        return $this->hasMany('App\SysRating', 'product_id');
    }

    /**
     * @return Collection
     */
    public static function allWithoutParents ()
    {
        $subquery = DB::table('sys_product')->select('parent_product_id')->whereNotNull('parent_product_id');
        $products = SysProduct::whereNotIn('id', $subquery)->get();
        // dd($products);
        return $products;
    }

    /**
     * @return string
     */
    public function getTeaser ()
    {
        $content = \Parsedown::instance()->text($this->description);
        $content = strip_tags($content);
        return substr($content, 0, 100) . ' ...';
    }

    /**
     * @return string
     */
    public function getFirstImageUri ()
    {
        if (is_string($this->media)) {
            return json_decode($this->media)[0];
        }
        return $this->media[0];
    }

    /**
     * @return mixed
     */
    public static function getHighestPricedProduct ()
    {
        return SysProduct::orderBy('price', 'desc')->limit(1)->get()->first();
    }

    /**
     * @param $query
     * @param $value
     *
     * @return mixed
     */
    public function scopeSearch ($query, $value)
    {
        return $query->where('name', 'like', "%$value%")
            ->orWhere('description', 'like', "%$value%")->get();
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getDescriptionAttribute ($value)
    {
        if ($this->hasParent() && empty($value)) {
            return $this->parent->attributes['description'];
        }
        return $value;
    }

    /**
     * @param $value
     *
     * @return float
     */
    public function getPriceAttribute ($value)
    {
        if ($this->hasParent() && empty($value)) {
            return $this->parent->attributes['price'];
        }
        return $value;
    }

    /**
     * @param $media
     *
     * @return array
     */
    public function getMediaAttribute ($media)
    {
        if ($this->hasParent() && empty($media)) {
            $parentMedia = $this->parent->attributes['media'];
            if (is_string($parentMedia)) {
                $parentMedia = json_decode($parentMedia);
            }
            return $parentMedia;
        }
        return $media;
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSiblingsAttribute ()
    {
        if ($this->hasParent()) {
            $products = SysProduct::query()
                ->where('parent_product_id', $this->parent->id)
                ->where('id', '!=', $this->id)
                ->get(['name', 'id']);
            return $products;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function hasParent ()
    {
        return $this->parent()->count() > 0;
    }
}
