<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
     * @param SysProduct $product
     */
    public function addProduct (SysProduct $product)
    {
        if (!$this->products->contains($product)) {
            $this->products()->attach($product);
        }
    }

    /**
     * @return bool
     */
    public function hasMedia ()
    {
        return is_array($this->media);
    }

    /**
     * @return string
     */
    public function getFirstImageUri ()
    {
        return $this->media[0];
    }

    /**
     * @return string
     */
    public function renderMarkdown ()
    {
        return \Parsedown::instance()->text($this->content);
    }
}
