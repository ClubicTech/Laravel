<?php


class APIUserTableSeeder extends Seeder {

  public function run()
  {
      DB::table('apiusers')->delete();

      APIUser::create(array('username' => 'maxim', 'password' => '18c3076399c6ce7f101c8b41b602468d', 'email' => 'maxim@ukr.net', 'hash' => '$2y$10$zPbYEG1MF00dNNrJCXZUeuKBYPbY2Pdd4OP6KeVUmsp0xo.NQiFq2', 'time' => 1400142672));
  }

}