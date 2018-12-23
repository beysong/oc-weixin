<?php namespace Beysong\Weixin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBeysongWeixinAdletTag extends Migration
{
    public function up()
    {
        Schema::create('beysong_weixin_adlet_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('adlet_id');
            $table->integer('tag_id');
            $table->primary(['adlet_id','tag_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('beysong_weixin_adlet_tag');
    }
}
