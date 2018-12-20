<?php namespace Beysong\Weixin\Models;

use App;
use Str;
use Model;
use October\Rain\Support\Markdown;

/**
 * Post Model
 */
class Wechatuser extends Model
{
	public $timestamps = false;

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'beysong_weixin_user';

	/**
	 * @var array The attributes that are mass assignable.
	 */
	protected $fillable = ['user_id', 'wechat_id'];

	/**
	 * @var array Relations
	 */
	public $belongsTo = [
		'user' => ['RainLab\User\Models\User']
	];
}