<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		User::create([
			'username' => 'superadmin',
			'email' => 'johnarbennicolehombrebueno@gmail.com',
			'password' => Hash::make("superadmin"),
			'status' => 1,
			'name' => 'superadmin',
			'member_type_id' => 0,
			]);
	}
}