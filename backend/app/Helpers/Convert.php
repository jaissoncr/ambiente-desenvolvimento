<?php

namespace MLTools\Helpers;

class Convert
{

    public static function objectToArray($obj)
    {

        if(is_object($obj)) {
            $obj = get_object_vars($obj);
        }

        return (is_array($obj)) ? array_map('self::objectToArray', $obj) : $obj;

    }

}