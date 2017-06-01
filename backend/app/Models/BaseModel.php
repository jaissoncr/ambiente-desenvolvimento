<?php
/**
 * Created by PhpStorm.
 * User: rafaelignacio
 * Date: 14/01/16
 * Time: 20:42
 */

namespace MLTools\Models;


use Illuminate\Database\Eloquent\Model;
use \Validator;
use MLTools\Contracts\IValidateModel;

class BaseModel extends Model implements IValidateModel
{

    /**
     * Erros encontrados pelo validator
     *
     * @var array
     */
    public $errors = [];

    /**
     * Regras de validação do model
     * @var array
     */
    public static $rules = [];

    public function validate()
    {

        if (empty(static::$rules)) {
            return true;
        }

        $validator = Validator::make($this->attributes, static::$rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->messages();
        return false;

    }

}