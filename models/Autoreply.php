<?php namespace Beysong\Weixin\Models;

use Model;

/**
 * Model
 */
class Autoreply extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'beysong_weixin_autoreply';
}
