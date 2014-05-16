<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration {

    public function up() {
        Schema::create('review', function($table) {
            $table->increments('id');
            $table->integer('rubric_id');
            $table->string('title');
            $table->string('description');
            $table->string('author');
        });
    }

    public function down() {
        Schema::drop('review');
    }

}
