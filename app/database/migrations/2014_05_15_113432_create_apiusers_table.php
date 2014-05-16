<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiusersTable extends Migration {
  public function up() {
        Schema::create('apiusers', function($table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->string('hash');
            $table->integer('time');
        });
    }

    public function down() {
        Schema::drop('apiusers');
    }	
}
