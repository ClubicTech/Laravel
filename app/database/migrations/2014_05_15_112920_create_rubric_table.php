<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubricTable extends Migration {

    public function up() {
        Schema::create('rubric', function($table) {
            $table->increments('id');
            $table->integer('root_id');
            $table->string('name');
            $table->string('description');
        });

        Schema::table('rubric', function($table) {
            $table->foreign('root_id')
                    ->references('id')->on('rubric')
                    ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('rubric');
    }

}
