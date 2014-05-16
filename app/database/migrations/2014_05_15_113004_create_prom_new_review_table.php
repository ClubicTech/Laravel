<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromNewReviewTable extends Migration {

	
	
    public function up() {
        Schema::create('prom_new_review', function($table) {
            $table->integer('news_id');
            $table->integer('review_id');
        });

        Schema::table('prom_new_review', function($table) {
            $table->foreign('news_id')
                    ->references('id')->on('news')
                    ->onDelete('cascade');
        });
        Schema::table('prom_new_review', function($table) {
            $table->foreign('review_id')
                    ->references('id')->on('review')
                    ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('prom_new_review');
    }


}
