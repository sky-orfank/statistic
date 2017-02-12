<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
			'id' => 1,
            'name' =>'admin',
            'email' =>'admin@test.com',
        	'password' => '$2y$10$8ZhaOFykEnrZpdMgeiWkWu3WP3I2nHFgaoZ1vQuMwNmcE/rgNTtGG',
        	'is_admin' => 1
        ]);
    }
}
