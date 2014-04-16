<?php






class UserTableSeeder extends Seeder {

  public function run()
  {
      DB::table('users')->delete();

      User::create(array('name' => 'Maxim','last_name' => 'Vovk'));
      User::create(array('name' => 'Petro','last_name' => 'Patkov'));
      User::create(array('name' => 'Makasin','last_name' => 'Manitu'));
  }

}







