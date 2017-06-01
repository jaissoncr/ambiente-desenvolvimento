<?php

namespace MLTools\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Store extends BaseModel implements AuthenticatableContract
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'site_id',
        'first_name',
        'last_name',
        'nickname',
        'email',
        'permalink',
        'avatar',
        'access_token',
        'token_type',
        'expires_in',
        'refresh_token',
        'scope',
    ];

    public static $rules = [
        'store_id' => 'required',
        'site_id' => 'required',
        'first_name' => 'required',
        'email' => 'required|email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return null;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($remember_token)
    {
        return true;
    }

    public function getRememberTokenName()
    {
        return null;
    }

    /**
     * Relationship store -> customers
     *
     */
    public function customers()
    {
        return $this->belongsToMany('MLTools\Models\Store', 'customers_stores', 'store_id', 'customer_id');
    }

    /**
     * Relationship store -> users
     *
     */
    public function users()
    {
        return $this->belongsToMany('MLTools\Models\Store', 'stores_users', 'store_id', 'user_id');
    }

    public function addUser(Store $user)
    {
        if ( empty($this->users()->where(['user_id'=>$user->id])->first()) )
            $this->users()->attach($user->id, ['created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
    }

    public function removeUser(Store $user)
    {
        $this->users()->detach($user->id);
    }

    /**
     * Relationship customer -> stores
     *
     */
    public function stores()
    {
        return $this->belongsToMany('MLTools\Models\Store', 'customers_stores', 'store_id', 'store_id');
    }

    /**
     * Relationship store -> tasks
     */
    public function tasks()
    {
        return $this->hasMany('MLTools\Models\Task', 'store_id', 'store_id');
    }

    /**
     * Relationship store -> notifications
     */
    public function notifications()
    {
        return $this->hasMany('MLTools\Models\Notification', 'store_id', 'user_id');
    }

    /**
     * Relationship store -> tasks
     */
    public function adverts()
    {
        return $this->hasMany('MLTools\Models\Advert', 'store_id', 'store_id');
    }

}
