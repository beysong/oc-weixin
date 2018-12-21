<?php namespace Beysong\Weixin\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Beysong\Weixin\Classes\WechatManager;
use Beysong\Weixin\Models\WechatMenu as WechatMenuModel;

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

    public function onSaveToWechat()
    {
        $app = WechatManager::instance()->app();
        
        $list = $app->menu->list();
        
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
        $parents = WechatMenuModel::where('parent_id', NULL)->orWhere('parent_id', 0)->get();
        $children = WechatMenuModel::where('parent_id', '<>', NULL)->where('parent_id', '<>', 0)->get();
        $buttons = [];
        foreach ($parents as $v) {
            $buttons[] = [
                "type" => $v["type"],
                "name" => $v["name"],
                "key" => $v["key"],
                "id" => $v["id"],
                "appid" => $v["appid"],
                "url" => $v["url"],
                "pagepath" => $v["pagepath"],
                "media_id" => $v["media_id"],
            ];
        }
        foreach ($buttons as $k=>$v) {
            foreach ($children as $vv) {
                if($v['id'] == $vv['parent_id']){
                    $buttons[$k]['sub_button'][]=[
                        "type" => $vv["type"],
                        "name" => $vv["name"],
                        "key" => $vv["key"],
                        "appid" => $vv["appid"],
                        "url" => $vv["url"],
                        "pagepath" => $vv["pagepath"],
                        "media_id" => $vv["media_id"],
                    ];
                }
            }
        }
        // dd($buttons);
        $result = $app->menu->create($buttons);
        // dd($result);
        // $list = $app->menu->list();
        // dd($list);
    }
}
