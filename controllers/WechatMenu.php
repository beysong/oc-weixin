<?php namespace Beysong\Weixin\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Beysong\Weixin\Classes\WechatManager;

class WechatMenu extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Beysong.Weixin', 'main-menu-item', 'side-menu-item2');
    }

    public function index()
    {
        parent::index();
        $app = WechatManager::instance()->app();
        
        $list = $app->menu->list();
        // dd($list);
        $this->vars['menuList'] = $list;
        // $buttons = [
        //     [
        //         "type" => "click",
        //         "name" => "今日歌曲",
        //         "key"  => "V1001_TODAY_MUSIC"
        //     ],
        //     [
        //         "name"       => "菜单",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "搜索",
        //                 "url"  => "http://www.soso.com/"
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "视频",
        //                 "url"  => "http://v.qq.com/"
        //             ],
        //             [
        //                 "type" => "click",
        //                 "name" => "赞一下我们",
        //                 "key" => "V1001_GOOD"
        //             ],
        //         ],
        //     ],
        // ];
        // $app->menu->create($buttons);

        // $list = $app->menu->list();
        // dd($list);
    }
}
