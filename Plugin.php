<?php namespace Beysong\Weixin;

use App;
use Config;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{
	public $require = ['Vdomah.JWTAuth'];
    public function registerComponents()
    {
		return [
			'Beysong\Weixin\Components\WechatSession' => 'WechatSession',
			'Beysong\Weixin\Components\Adlets' => '小广告'
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
