<?php

class UserController extends BaseController {

	public function listUser($type = 'user')
	{
		$content = Role::with('users')->whereName($type)->first();
		return View::make('page.officer.userlist')
			->with('title','Daftar User')
			->with('content',$content);
	}

	public function create($type = 'user')
	{
		if($type == 'user')
		{
			return View::make('page.officer.userform')
				->with('title','Tambah user')
				;
		}
	}

	public function store($type = 'user')
	{
		$role = Role::where('name',$type)->first();
		$en = Input::get('enabled');
		if(empty($en))
			$en='';
		$user = User::create([
			'name' => Input::get('name'),
			'username' => Input::get('username'),
			'password' => Hash::make(Input::get('password')),
			'email' => Input::get('email'),
			'enabled' => $en
		]);

		$user->roles()->attach($role->id);
		Session::flash('success','Data berhasil ditambahkan');
		return Redirect::back();
	}

	public function edit($id=null)
	{
		$content = User::find($id);
		return View::make('page.officer.userform')
		->with('title','Edit Pengguna')
		->with('content',$content)
		;
	}
	public function update($id=null)
	{
		$content = User::find($id);
		$en = Input::get('enabled');
		if(empty($en))
			$content->enabled = '';
		else
			$content->enabled = '1';
		$content->name = Input::get('name');
		$content->email = Input::get('email');
		$content->save();

		return View::make('page.officer.userform')
		->with('title','Edit Pengguna')
		->with('content',$content)
		;
	}
	public function reset($id=null)
	{
		$user = User::find($id);
		$user->password = Hash::make($user->username);
		$user->save();
		Session::flash('success','Password berhasil di reset.(sama dengan username)');
		return Redirect::back();
	}
}
