<?php namespace Beysong\Weixin\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'beysong_weixin_tag';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        'adlets' => ['Beysong\Weixin\Models\Adlet',
            'table' => 'beysong_weixin_adlet_tag',
            'order' => 'title',
        ]
    ];
}
