<?php

class AuthSeeder extends Seeder {

	public function run()
	{
		Role::truncate();
		User::truncate();
		Role::create([
			'name'=>'admin'
		]);
		Role::create([
			'name'=>'officer'
		]);
		Role::create([
			'name'=>'user'
		]);

		$a = User::create([
			'username' => 'admin',
			'password' => Hash::make('1234'),
			'email' => 'alvarisi@live.com',
			'enabled' => '1'
		]);
		$a->roles()->attach(1);

		$b = User::create([
			'username' => 'officer',
			'password' => Hash::make('1234'),
			'email' => 'alvarisi@live.com',
			'enabled' => '1'
		]);
		$b->roles()->attach(2);
	}

}
