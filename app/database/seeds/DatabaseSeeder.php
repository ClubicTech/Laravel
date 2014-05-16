<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('APIUserTableSeeder');
                $this->command->info('Таблица APIUser загружена данными!');

		$this->call('RubricTableSeeder');
                $this->command->info('Таблица Rubric загружена данными!');
		
                $this->call('TagTableSeeder');
                $this->command->info('Таблица Tag загружена данными!');

                $this->call('NewsTableSeeder');
                $this->command->info('Таблица News загружена данными!');
		
                $this->call('ReviewsTableSeeder');
                $this->command->info('Таблица Reviews загружена данными!');
	}

}