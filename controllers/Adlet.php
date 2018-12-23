<?php namespace Beysong\Weixin\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Adlet extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Beysong.Weixin', 'main-menu-item', 'side-menu-item-adlet');
    }
}
