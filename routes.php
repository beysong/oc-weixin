<?php
// use Session;
use Beysong\Weixin\Models\Settings;
use EasyWeChat\Factory;
use Beysong\Weixin\Classes\WechatManager;

require_once('vendor/autoload.php');

Route::post('wechat/server', array('middleware' => ['web'], function($provider_name, $action = "")
{
    
    // $wechat = app('wechat.official_account');
    $wechat = WechatManager::instance()->app();

    // $response = $wechat->server->serve();
    // // 将响应输出
    // $response->send();exit; // Laravel 里请使用：return $response;

    $wechat->server->push(function($message){
        \Log::info($message->MsgType);
        \Log::info($message);
        switch ('text') {
            case 'event':
            if($message->Event == 'subscribe'){
                return '感谢关注';
                break;
            }
            return '收到事件消息';
            break;
            case 'text':
            \Log::info('return response2.');
            return '收到文字消息';
            break;
            case 'image':
            return '收到图片消息';
            break;
            case 'voice':
            return '收到语音消息';
            break;
            case 'video':
            return '收到视频消息';
            break;
            case 'location':
            return '收到坐标消息';
            break;
            case 'link':
            return '收到链接消息';
            break;
            // ... 其它消息
            default:
            return '收到其它消息';
            break;
        }
    });

    \Log::info('return response.');

    return $wechat->server->serve();

}));
// http://home.flynsarmy.com/flynsarmy/sociallogin/Google?s=/&f=/login
Route::get('auth/session', array('middleware' => ['web'], function($provider_name, $action = "")
{
    $app = WechatManager::instance()->app();
    // $app = EasyWeChat\Factory::miniProgram($config);
    $session_third = $app->auth->session(Input::get('code'));
    return response()->json(['data'=>['login_code'=>'login_code', 'third_session'=>'------', 'test'=>$session_third], 'code'=>0]);
}));
Route::get('auth/check_session', array('middleware' => ['web'], function($provider_name, $action = "")
{
    return response()->json(['data'=>[], 'code'=>0]);
}));
Route::get('beysong/weixin/wechat_callback', array('middleware' => ['web'], function()
{
    // $options = [
    //     'debug'  => true,
    //     'app_id' => Settings::get('appid', 501),
    //     'token' => Settings::get('token', 502),
    //     'secret'  => Settings::get('secret', 503),
    //     'oauth' => [
    //         'scopes'   => ['snsapi_userinfo'],
    //         'callback' => '/beysong/weixin/wechat_callback',
    //     ],
    //     // 'aes_key' => null, // 可选
    //     'log' => [
    //         'level' => 'debug',
    //         'file'  => '/tmp/easywechat.log', // XXX: 绝对路径！！！！
    //     ],
    //     //...
    // ];

    // $app = Factory::officialAccount($options);
    $app = WechatManager::instance()->app();
    // $app = Factory::officialAccount();
    $oauth = $app->oauth;
    
    // 获取 OAuth 授权结果用户信息
    $user = $oauth->user();
    // dd($user);
    Session::put('wechat_user', $user->toArray());
    $targetUrl = !empty(Session::get('target_url')) ? '/' : Session::get('target_url');
    $user2 = \Beysong\Weixin\Classes\UserManager::instance()->find(
        $user->toArray()
    );
        Auth::login($user2);

    header('location:'. $targetUrl); // 跳转到 user/profile
}));
