<?php


class RubricTableSeeder extends Seeder {

  public function run()
  {
      DB::table('rubric')->delete();

      Rubric::create(array('root_id' => '0','name' => 'General', 'description' => 'This general rubric'));
      Rubric::create(array('root_id' => '1','name' => 'Sport', 'description' => 'This rubric for sport news'));
      Rubric::create(array('root_id' => '1','name' => 'House', 'description' => 'This rubric for news rent and sale house'));
      Rubric::create(array('root_id' => '2','name' => 'footbal', 'description' => 'This rubric for footbal news'));
      Rubric::create(array('root_id' => '2','name' => 'basketbal', 'description' => 'This rubric for basketbal news'));
      Rubric::create(array('root_id' => '3','name' => 'RentHouse', 'description' => 'This rubric for news RentHouse'));
      Rubric::create(array('root_id' => '3','name' => 'SaleHouse', 'description' => 'This rubric for news SaleHouse'));
  }

}







