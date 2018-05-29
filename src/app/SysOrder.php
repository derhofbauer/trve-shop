<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysOrder
 *
 * @package App
 */
class SysOrder extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_PROGRESS = 1;
    const STATUS_SHIPPED = 2;
    const STATUS_CANCELLED = 99;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'invoice',
        'feuser_id',
        'delivery_address',
        'payment_method'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feuser ()
    {
        return $this->belongsTo('App\SysFeuser', 'feuser_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsMM ()
    {
        return $this->hasMany('App\SysOrderProductMM', 'order_id');
    }

    /**
     * @return float|int
     */
    public function priceTotal ()
    {
        $price = 0;
        foreach ($this->productsMM as $productMM) {
            $price += $productMM->product->price * $productMM->product_quantity;
        }
        return $price;
    }

    /**
     * @return array
     */
    public function getProducts ()
    {
        $products = [];

        foreach ($this->productsMM as $productMM) {
            $products[] = $productMM->product;
        }

        return $products;
    }

    /**
     * @return array
     */
    public function getProductsFromJson ()
    {
        $products = json_decode($this->invoice);

        return $products;
    }

    /**
     * @return float|int
     */
    public function getPriceFromInvoice ()
    {
        $price = 0;
        foreach ($this->getProductsFromJson() as $product) {
            $price += $product->price * $product->quantity;
        }

        return $price;
    }

    /**
     * @return array
     */
    public static function getStates ()
    {
        return [
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_PROGRESS => __('In Progress'),
            self::STATUS_SHIPPED => __('Shipped'),
            self::STATUS_CANCELLED => __('Cancelled')
        ];
    }
}
