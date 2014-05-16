<?php


class TagTableSeeder extends Seeder {

  public function run()
  {
      DB::table('tag')->delete();
      Tag::create(array('tag_text' => 'check sale'));
      Tag::create(array('tag_text' => 'check rent'));
      Tag::create(array('tag_text' => 'Gooooll'));
      Tag::create(array('tag_text' => 'Gol'));
      Tag::create(array('tag_text' => 'bol in the basket'));
  }

}







