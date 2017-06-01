<?php

namespace MLTools\Models;

class Notification extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'resource',
        'topic',
        'sent',
        'received',
        'processed'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public static $rules = [
        'user_id' => 'required',
        'resource' => 'required',
        'topic' => 'required',
        'sent' => 'required',
        'received' => 'required',
    ];

    /**
     * Relationship customer -> stores
     *
     */
    public function store()
    {
        return $this->belongsTo('MLTools\Models\Store', 'store_id', 'user_id');
    }

}
