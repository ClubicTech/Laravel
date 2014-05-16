<?php


class NewsTableSeeder extends Seeder {

  public function run()
  {
      DB::table('news')->delete();

      News::create(array('rubric_id' => '2', 'title' => 'some title for sports news', 'description' => 'Its sports news', 'author' => 'Maxim Vovk'));
      News::create(array('rubric_id' => '3', 'title' => 'some title for house news', 'description' => 'Its rentand sale house news', 'author' => 'Maxim Vovk'));
      News::create(array('rubric_id' => '4', 'title' => 'Footbal FKDK vs FKDSh', 'description' => 'The very big game in premier liga Ukraine', 'author' => 'Maxim Vovk'));
      News::create(array('rubric_id' => '5', 'title' => 'M.Jordan:"I back"', 'description' => 'Very great champion in bascetbal sports M.Jordan', 'author' => 'Maxim Vovk'));
      News::create(array('rubric_id' => '6', 'title' => 'Rent this House', 'description' => 'Its very cool house', 'author' => 'Maxim Vovk'));
      News::create(array('rubric_id' => '7', 'title' => 'You mast sale house', 'description' => 'some description this news', 'author' => 'Maxim Vovk'));
  }

}