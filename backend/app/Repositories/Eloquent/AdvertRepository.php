<?php

namespace MLTools\Repositories\Eloquent;

use MLTools\Contracts\IAdvertRepository;
use MLTools\Models\Store;
use MLTools\Models\Advert;

class AdvertRepository implements IAdvertRepository
{
    private $model;

    public function __construct(Advert $model)
    {
        $this->model = $model;
    }

    public function findOrCreate(array $data)
    {
        if (empty($data)) {
            throw new \Exception('Os dados para cadastros são obrigatórios.');
        } elseif (!array_key_exists('id', $data) || !$data['id']) {
            throw new \Exception('O id do anúncio é obrigatório.');
        } elseif (!array_key_exists('seller_id', $data) || (int)$data['seller_id'] <= 0) {
            throw new \Exception('O vendedor do anúncio é obrigatório.');
        }

        $advert = $this->model->where('ml_id', '=', $data['id'])->first();
        if(!$advert) {
            $this->model = new $this->model([
                'store_id' => isset($data['seller_id']) ? $data['seller_id'] : null,
                'ml_id' => isset($data['id']) ? $data['id'] : null,
                'site_id' => isset($data['site_id']) ? $data['site_id'] : null,

                'title' => isset($data['title']) ? $data['title'] : null,
                'subtitle' => isset($data['subtitle']) ? $data['subtitle'] : null,

                'category_id' => isset($data['category_id']) ? $data['category_id'] : null,

                'price' => isset($data['price']) ? $data['price'] : null,
                'base_price' => isset($data['base_price']) ? $data['base_price'] : null,
                'original_price' => isset($data['original_price']) ? $data['original_price'] : null,

                'initial_quantity' => isset($data['initial_quantity']) ? $data['initial_quantity'] : null,
                'available_quantity' => isset($data['available_quantity']) ? $data['available_quantity'] : null,
                'sold_quantity' => isset($data['sold_quantity']) ? $data['sold_quantity'] : null,

                'currency_id' => isset($data['currency_id']) ? $data['currency_id'] : null,
                'buying_mode' => isset($data['buying_mode']) ? $data['buying_mode'] : null,
                'listing_type_id' => isset($data['listing_type_id']) ? $data['listing_type_id'] : null,
                'condition' => isset($data['condition']) ? $data['condition'] : null,
                'accepts_mercadopago' => isset($data['accepts_mercadopago']) ? $data['accepts_mercadopago'] : null,
                'free_shipping' => isset($data['shipping']['free_shipping']) ? $data['shipping']['free_shipping'] : null,
                'status' => isset($data['status']) ? $data['status'] : null,
                'automatic_relist' => isset($data['automatic_relist']) ? $data['automatic_relist'] : null,

                'thumbnail' => isset($data['thumbnail']) ? $data['thumbnail'] : null,
                'secure_thumbnail' => isset($data['secure_thumbnail']) ? $data['secure_thumbnail'] : null,

                'start_time' => isset($data['start_time']) ? $data['start_time'] : null,
                'stop_time' => isset($data['stop_time']) ? $data['stop_time'] : null,
                'date_created' => isset($data['date_created']) ? $data['date_created'] : null,
                'last_updated' => isset($data['last_updated']) ? $data['last_updated'] : null,
            ]);
            if ($this->model->validate()) {
                $this->model->save();
                $advert = $this->model;
            }
        }

        return $advert;

    }

    public function findByStore(Store $user)
    {
        return $user->adverts()
            ->whereNull('deleted_at')
            ->get();
    }

}