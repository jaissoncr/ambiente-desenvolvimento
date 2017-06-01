<?php
/**
 * Created by PhpStorm.
 * User: rafaelignacio
 * Date: 05/02/16
 * Time: 01:33
 */

namespace MLTools\Services\Meli;


class Order
{

    private $meli;

    public function __construct()
    {
        $this->meli = \App::make('MeliUser');
    }

}