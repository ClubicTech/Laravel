<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromTagNewTable extends Migration {

			
    public function up() {
        Schema::create('prom_tag_new', function($table) {
            $table->integer('tag_id');
            $table->integer('news_id');
        });

        Schema::table('prom_tag_new', function($table) {
            $table->foreign('news_id')
                    ->references('id')->on('news')
                    ->onDelete('cascade');
        });
        Schema::table('prom_tag_new', function($table) {
            $table->foreign('tag_id')
                    ->references('id')->on('tag')
                    ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('prom_tag_new');
    }

}
