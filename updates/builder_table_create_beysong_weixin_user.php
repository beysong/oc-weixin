<?php namespace Beysong\Weixin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBeysongWeixinUser extends Migration
{
    public function up()
    {
        Schema::create('beysong_weixin_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->string('wechat_id', 64);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('beysong_weixin_user');
    }
}
