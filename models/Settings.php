<?php namespace Beysong\Weixin\Models;

use Model;

class Settings extends Model
{
	public $implement = ['System.Behaviors.SettingsModel'];

	// A unique code
	public $settingsCode = 'beysong_weixin_settings';

	// Reference to field configuration
	public $settingsFields = 'fields.yaml';

	protected $cache = [];
}