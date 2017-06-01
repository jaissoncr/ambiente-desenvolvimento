<?php

namespace MLTools\Services\Meli;

use MLTools\Models\Store;

/**
 * Class Item
 * @package MLTools\Services\Meli
 *
 * /items -> POST -> store
 * /items/validate -> POST -> validate store
 * /items/{Item_id} -> GET, PUT -> find, update
 * /items/{Item_id}/available_upgrades -> GET
 * /items/{Item_id}/relist -> POST
 * /items/{Item_id}/pictures -> GET, POST
 * /items/{Item_id}/description -> GET, PUT
 * /users/{Cust_id}/items/search?access_token=$ACCESS_TOKEN -> GET
 * /items/{Item_id}/product_identifiers/ -> GET, PUT
 *
 */
class Item
{

    private $meli;
    private $user;
    private $path = 'items';

    public function __construct(Store $user)
    {
        $this->meli = \App::make('MeliUser');
        $this->user = $user;
    }

    public function itemsByUser($page = 1, $limit = 50)
    {
        return $this->meli->get('users/' . $this->user->store_id . '/'. $this->path .'/search', [
            'access_token' => $this->user->access_token,
            'limit' => $limit,
            'offset' => ($page * $limit) - $limit,
        ]);
    }

    public function get($id)
    {
        return $this->meli->get($this->path . '/' . $id);
    }

    public function getDescription($id)
    {
        return $this->meli->get($this->path . '/' . $id . '/description');
    }

    public function getPictures($id)
    {
        return $this->meli->get($this->path . '/' . $id . '/pictures', [
            'access_token' => $this->user->access_token,
        ]);
    }

}
