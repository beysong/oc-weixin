<?php
// use Session;
use Beysong\Weixin\Models\Settings;
use EasyWeChat\Factory;
use Beysong\Weixin\Classes\WechatManager;
use Beysong\Weixin\Models\Adlet;

require_once('vendor/autoload.php');

Route::post('wechat/server', array('middleware' => ['web'], function($provider_name, $action = "")
{
    
    $wechat = WechatManager::instance()->app();

    // 微信验证服务器
    // $response = $wechat->server->serve();
    // $response->send();exit; 

    $wechat->server->push(function($message){
        switch ($message['MsgType']) {
            case 'event':
            if($message['Event'] == 'subscribe'){
                return '感谢关注';
                break;
            }
            return '收到事件消息';
            break;
            case 'text':
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
Route::get('miniprogram/server', array('middleware' => ['web'], function($provider_name, $action = "")
{
    
    $wechat = WechatManager::instance()->app();

    // 微信验证服务器
    $response = $wechat->server->serve();
    $response->send();exit; 

    $wechat->server->push(function($message){
        return "您好！欢迎使用爱打听!";
    });

    return $wechat->server->serve();

}));

Route::get('auth/session', array('middleware' => ['web'], function($provider_name, $action = "")
{
    $app = WechatManager::instance()->app();
    $session_third = $app->auth->session(Input::get('code'));
    return response()->json(['data'=>['login_code'=>'login_code', 'third_session'=>'------', 'test'=>$session_third], 'code'=>0]);
}));
Route::get('auth/check_session', array('middleware' => ['web'], function($provider_name, $action = "")
{
    return response()->json(['data'=>[], 'code'=>0]);
}));
Route::get('beysong/weixin/wechat_callback', array('middleware' => ['web'], function()
{
    
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

    header('location:'. $targetUrl);
}));
Route::get('beysong/weixin/js_login', array('middleware' => ['web'], function()
{
    
    // dd(Request::get('js_code'));
    $app = WechatManager::instance()->miniProgram();
    $user = $app->auth->session(Request::get('js_code'));
    // dd($user);
    // $app = Factory::officialAccount();
    // return response()->json(['data'=>$user, 'code'=>0]);

    // $rrr = Http::post('/api/login', array('email'=> 'beysong@dev.com', 'password'=>'sdfsdf'));
    // $rrr = Request::create('/api/login');
    // dd($rrr);

    // return response()->json(['data'=> $user]);
    $user2 = \Beysong\Weixin\Classes\UserManager::instance()->find(
        array('id'=> $user['openid'], 'session_key'=> $user['session_key'])
    );
    $token = JWTAuth::fromUser($user2);
    return response()->json(compact('token', 'user2'));

}));
Route::post('beysong/weixin/test', function (\Request $request) {
    return response()->json(('The test was successful'));
 })->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');

 Route::get('beysong/weixin/adlet', function (\Request $request) {
    $adlets = Adlet::with('imgs')->where('status', '1')->get();
    return response()->json(['data'=> $adlets]);
 })->middleware('\Tymon\JWTAuth\Middleware\GetUserFromToken');
