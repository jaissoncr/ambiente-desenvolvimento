<?php
/**
 * Created by PhpStorm.
 * User: rafaelignacio
 * Date: 05/02/16
 * Time: 01:36
 */

namespace MLTools\Services\Meli;


class Category
{

    private $meli;

    public function __construct()
    {
        $this->meli = \App::make('MeliUser');
    }

}