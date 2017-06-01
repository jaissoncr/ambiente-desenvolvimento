<?php

namespace MLTools\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'title',
        'completed',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public static $rules = [
        'store_id' => 'required',
        'title' => 'required',
    ];

    public function getCompletedAttribute($value)
    {
        return (boolean)$value;
    }

    /**
     * Relationship customer -> stores
     *
     */
    public function store()
    {
        return $this->belongsTo('MLTools\Models\Store');
    }

}
