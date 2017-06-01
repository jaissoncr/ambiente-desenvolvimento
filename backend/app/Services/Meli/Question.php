<?php
/**
 * Created by PhpStorm.
 * User: rafaelignacio
 * Date: 05/02/16
 * Time: 01:35
 */

namespace MLTools\Services\Meli;


class Question
{

    private $meli;

    public function __construct()
    {
        $this->meli = \App::make('MeliUser');
    }

}