<?php

namespace MLTools\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'adverts';

    protected $fillable = [
        'store_id',
        'ml_id',
        'site_id',

        'title',
        'subtitle',

        'category_id',

        'price',
        'base_price',
        'original_price',

        'initial_quantity',
        'available_quantity',
        'sold_quantity',

        'currency_id',
        'buying_mode',
        'listing_type_id',
        'condition',
        'accepts_mercadopago',
        'free_shipping',
        'status',
        'automatic_relist',

        'thumbnail',
        'secure_thumbnail',

        'start_time',
        'stop_time',
        'date_created',
        'last_updated',
    ];

    public static $rules = [
        'store_id' => 'required',
        'ml_id' => 'required|unique:adverts',
        'site_id' => 'required',
    ];

    /**
     * Relationship adverts -> stores
     *
     */
    public function store()
    {
        return $this->belongsTo('MLTools\Models\Store');
    }


}