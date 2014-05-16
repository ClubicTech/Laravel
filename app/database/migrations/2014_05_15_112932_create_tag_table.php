<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration {

    public function up() {
        Schema::create('tag', function($table) {
            $table->increments('id');
            $table->string('tag_text');
        });
    }

    public function down() {
        Schema::drop('tag');
    }

}
