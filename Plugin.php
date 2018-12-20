<?php namespace Beysong\Weixin;

use App;
use Config;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
		return [
			'Beysong\Weixin\Components\WechatSession' => 'WechatSession'
		];
    }

    public function registerSettings()
    {
		return [
			'settings' => [
				'label'       => 'Weixin Login',
				'description' => 'Manage Social Login providers.',
				'icon'        => 'icon-users',
				'class'       => 'Beysong\Weixin\Models\Settings',
				'order'       => 600,
                'permissions' => ['rainlab.users.access_settings'],
			]
		];
	}
	
    public function boot(){
        // Setup required packages
        $this->bootPackages();
        // App::register('\Overtrue\LaravelWechat\ServiceProvider');
        // // Register aliases
        // $alias = AliasLoader::getInstance();
        // $alias->alias('LaravelWechat', 'Overtrue\LaravelWechat\Facade');


        // \Event::listen('Overtrue\LaravelWeChat\Events\WeChatUserAuthorized', function($event)
        // {
        //     // dd($event);
        //     dd($oauth->user()->toArray());
        // });
    }

    /**
    * Boots (configures and registers) any packages found within this plugin's packages.load configuration value
    *
    * @see https://luketowers.ca/blog/how-to-use-laravel-packages-in-october-plugins
    * @author Luke Towers <octobercms@luketowers.ca>
    */
    public function bootPackages()
    {
        // Get the namespace of the current plugin to use in accessing the Config of the plugin
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));

        // Instantiate the AliasLoader for any aliases that will be loaded
        $aliasLoader = AliasLoader::getInstance();

        // Get the packages to boot
        $packages = Config::get($pluginNamespace . '::packages');

        // Boot each package
        foreach ($packages as $name => $options) {
            // Setup the configuration for the package, pulling from this plugin's config
            if (!empty($options['config']) && !empty($options['config_namespace'])) {
                Config::set($options['config_namespace'], $options['config']);
            }

            // Register any Service Providers for the package
            if (!empty($options['providers'])) {
                foreach ($options['providers'] as $provider) {
                    App::register($provider);
                }
            }

            // Register any Aliases for the package
            if (!empty($options['aliases'])) {
                foreach ($options['aliases'] as $alias => $path) {
                    $aliasLoader->alias($alias, $path);
                }
            }
        }
    }
}


// https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx31b92b41c42c99f4&
// redirect_uri=http%3A%2F%2Fhomestead.test%2F&
// response_type=code&scope=snsapi_userinfo&
// state=dc4a392bcf144c6567ca13f7d88b0529&
// connect_redirect=1&uin=MjkwMzM0MjE0MQ%3D%3D&
// key=ff3783ffb2496c41c200b7cf4a7a344abc1bec508b7e624c9b5516d15bc60ada680e62779adf7752c30378c3a994691b&
// pass_ticket=CA/H+PmRWKkcpG6VwLtPSAVn9hvDuFDoID7VN4UR9yl+PI5HodUlxZ6k+i4NI/FxVGd9mXpIwPBcDMHt+0x5aA==