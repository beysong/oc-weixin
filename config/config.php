<?php
return [
    // This contains the Laravel Packages that you want this plugin to utilize listed under their package identifiers
    'packages' => [
        'overtrue/laravel-wechat' => [
            // Service providers to be registered by your plugin
            'providers' => [
                'Overtrue\LaravelWeChat\ServiceProvider',
            ],

            // Aliases to be registered by your plugin in the form of $alias => $pathToFacade
            'aliases' => [
                'EasyWeChat' => '\Overtrue\LaravelWeChat\Facade',
            ],

            // The namespace to set the configuration under. For this example, this package accesses it's config via config('purifier.' . $key), so the namespace 'purifier' is what we put here
            'config_namespace' => 'beysong.wechat',

            // The configuration file for the package itself. Start this out by copying the default one that comes with the package and then modifying what you need.
            'config' => [
                /**
                * Debug 模式，bool 值：true/false
                *
                * 当值为 false 时，所有的日志都不会记录
                */
                'debug'  => true,
                /**
                * 账号基本信息，请从微信公众平台/开放平台获取
                */
                'app_id'  => 'wx31b92b41c42c99f4',         // AppID
                'secret'  => 'de61fe24fe3a274a8e80bc53bf10584d',     // AppSecret
                'token'   => 'dobechina',          // Token
                'aes_key' => '',                    // EncodingAESKey，安全模式下请一定要填写！！！
                /**
                * 日志配置
                *
                * level: 日志级别, 可选为：
                *         debug/info/notice/warning/error/critical/alert/emergency
                * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
                * file：日志文件位置(绝对路径!!!)，要求可写权限
                */
                'log' => [
                    'level'      => 'debug',
                    'permission' => 0777,
                    'file'       => '/tmp/easywechat.log',
                ],
                /**
                * OAuth 配置
                *
                * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
                * callback：OAuth授权完成后的回调页地址
                */
                'oauth' => [
                    'scopes'   => ['snsapi_userinfo'],
                    'callback' => '/examples/oauth_callback.php',
                ],
                /**
                * 微信支付
                */
                'payment' => [
                    'merchant_id'        => 'your-mch-id',
                    'key'                => 'key-for-signature',
                    'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
                    'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
                    // 'device_info'     => '013467007045764',
                    // 'sub_app_id'      => '',
                    // 'sub_merchant_id' => '',
                    // ...
                ],
                /**
                * Guzzle 全局设置
                *
                * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
                */
                'guzzle' => [
                    'timeout' => 3.0, // 超时时间（秒）
                    //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
                ],
                /*
                * 开发模式下的免授权模拟授权用户资料
                *
                * 当 enable_mock 为 true 则会启用模拟微信授权，用于开发时使用，开发完成请删除或者改为 false 即可
                */
                'enable_mock' => env('WECHAT_ENABLE_MOCK', true),
                'mock_user' => [
                    'openid' => 'odh7zsgI75iT8FRh0fGlSojc9PWM',
                    // 以下字段为 scope 为 snsapi_userinfo 时需要
                    'nickname' => 'overtrue',
                    'sex' => '1',
                    'province' => '北京',
                    'city' => '北京',
                    'country' => '中国',
                    'headimgurl' => 'http://wx.qlogo.cn/mmopen/C2rEUskXQiblFYMUl9O0G05Q6pKibg7V1WpHX6CIQaic824apriabJw4r6EWxziaSt5BATrlbx1GVzwW2qjUCqtYpDvIJLjKgP1ug/0',
                ],
            ],
        ],
    ],
];
