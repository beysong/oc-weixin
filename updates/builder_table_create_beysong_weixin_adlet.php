<?php namespace Beysong\Weixin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBeysongWeixinAdlet extends Migration
{
    public function up()
    {
        Schema::create('beysong_weixin_adlet', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('desc')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable()->default('1');
            $table->integer('sort')->nullable()->default(100);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('beysong_weixin_adlet');
    }
}
