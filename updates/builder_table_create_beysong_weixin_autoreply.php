<?php namespace Beysong\Weixin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBeysongWeixinAutoreply extends Migration
{
    public function up()
    {
        Schema::create('beysong_weixin_autoreply', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type');
            $table->string('keywords');
            $table->string('reply');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('beysong_weixin_autoreply');
    }
}
