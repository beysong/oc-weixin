<?php namespace Beysong\Weixin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBeysongWeixinMenu extends Migration
{
    public function up()
    {
        Schema::create('beysong_weixin_menu', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 32);
            $table->string('key', 128)->nullable();
            $table->string('type', 32);
            $table->string('url')->nullable();
            $table->string('media_id')->nullable();
            $table->string('appid', 128)->nullable();
            $table->string('pagepath')->nullable();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('beysong_weixin_menu');
    }
}
