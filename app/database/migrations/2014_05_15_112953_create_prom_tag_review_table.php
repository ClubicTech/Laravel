<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromTagReviewTable extends Migration {

		
    public function up() {
        Schema::create('prom_tag_review', function($table) {
            $table->integer('tag_id');
            $table->integer('review_id');
        });

        Schema::table('prom_tag_review', function($table) {
            $table->foreign('review_id')
                    ->references('id')->on('review')
                    ->onDelete('cascade');
        });
        Schema::table('prom_tag_review', function($table) {
            $table->foreign('tag_id')
                    ->references('id')->on('tag')
                    ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('prom_tag_review');
    }
}
